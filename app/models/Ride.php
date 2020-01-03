<?php
class Ride
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRides()
    {
        $this->db->query('SELECT posts.id,posts.source,posts.destination,posts.departure,posts.vehicle,posts.seats,posts.contact, posts.vehicle_id,users.full_name FROM posts INNER JOIN users ON posts.user_id = users.id WHERE available=1 AND users.id <> :userid');
        
        if(isset($_SESSION['user_id'])){
           $user_id = $_SESSION['user_id'];
        } else {
            $user_id = 0;
        }
        
        $this->db->bind(':userid', $user_id);
        $results = $this->db->resultSet();

        return $results;
    }

    public function getUserRides()
    {
        $this->db->query('SELECT * FROM posts WHERE user_id=:userid');
        $this->db->bind(':userid', $_SESSION['user_id']);
        $results = $this->db->resultSet();
        return $results;
    }

    public function addRide($data)
    {

        $this->db->query('INSERT INTO posts (user_id,source,destination,departure,vehicle,seats,contact,vehicle_id) VALUES (:user_id, :source, :destination, :departure, :vehicle, :seats, :contact, :vehicle_id)');

        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':source', $data['source']);
        $this->db->bind(':destination', $data['destination']);
        $this->db->bind(':departure', $data['departure']);
        $this->db->bind(':vehicle', $data['vehicle']);
        $this->db->bind(':seats', $data['seats']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':vehicle_id', $data['vehicle_id']);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRide($ride_id)
    {
        $this->db->query('DELETE FROM posts WHERE id= :rideid');
        $this->db->bind(':rideid', $ride_id);
        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getRideById($ride_id)
    {
        $this->db->query('SELECT * FROM posts WHERE id=:rideid');
        $this->db->bind(':rideid', $ride_id);
        $result = $this->db->single();
        return $result;
    }

    public function updateRide($data)
    {

        if($data['seats']){
            $this->setAvaiable($data['rideid']);
        }

        $this->db->query('UPDATE posts SET
                source = :source,
                destination = :destination,
                departure = :departure,
                vehicle = :vehicle,
                seats = :seats, 
                contact = :contact,
                vehicle_id = :vehicle_id
                WHERE id=:rideid');
        $this->db->bind(':source', $data['source']);
        $this->db->bind(':destination', $data['destination']);
        $this->db->bind(':departure', $data['departure']);
        $this->db->bind(':vehicle', $data['vehicle']);
        $this->db->bind(':seats', $data['seats']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':vehicle_id', $data['vehicle_id']);
        $this->db->bind(':rideid', $data['rideid']);


        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserSession($ride_id)
    {

        $this->db->query('SELECT user_id FROM posts WHERE id= :rideid');
        $this->db->bind(':rideid', $ride_id);
        $user_id = $this->db->single();
        return $user_id;
    }

    public function selectRide($ride_id)
    {
        
        //update selected from post add current_session_id 
        //decrement no of seats
        if($this->addSelected($ride_id)){
        
            //set available to false
        //if no of seats is = 0
            if(!$this->getSeats($ride_id)){
                $this->setAvaiable($ride_id);
            }
            return true;
        }
        
        return false;
    }

    public function getSeats($ride_id){
        $this->db->query('SELECT seats FROM posts WHERE id=:rideid');
        $this->db->bind(':rideid', $ride_id);
        $result = $this->db->single();
        return (int)$result->seats;
    }


    //toggles available flag 
    public function setAvaiable($ride_id)
    {
        $this->db->query('SELECT available FROM posts WHERE id=:rideid');
        $this->db->bind(':rideid', $ride_id);
        $result = $this->db->single();  
        
        $available = (int)$result->available;

        if(!$available){
            $available = 1;
        } else {
            $available = 0;
        }
        
        //set available  
        $this->db->query('UPDATE posts SET
        available = :available WHERE id=:rideid');
        $this->db->bind(':available', $available);
        $this->db->bind(':rideid', $ride_id);

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function addSelected($ride_id){
        
        $result = [];
 
        $result = $this->getJsonDecodeOfSelected($ride_id);

        //push another user_id 
        $result[] = (int)$_SESSION['user_id'];

        //encode it
        $result = json_encode($result);

        //update in db
        $this->db->query('UPDATE posts SET
        selected = :selected, seats = seats - 1 WHERE id=:rideid');
        $this->db->bind(':selected', $result);
        $this->db->bind(':rideid', $ride_id);

        if ($this->db->execute()) {
            return true;
        }
        return false;        

    }

    protected function getJsonDecodeOfSelected($ride_id){

                //bring json data from db
                $this->db->query('SELECT selected FROM posts WHERE id=:rideid');
                $this->db->bind(':rideid', $ride_id);
                $result = $this->db->single();
                $selected = json_decode($result->selected, true);

                if(empty($selected)){
                    return [];  
                }
                return $selected;       
         
    }

    public function removeSelected($ride_id){

        $user_id_array = $this->getJsonDecodeOfSelected($ride_id);

        foreach($user_id_array as $key => $value){
            if((int)$_SESSION['user_id'] === $value){
                unset($user_id_array[$key]);
            }
        }
        
        $this->jsonEncodeAndPostAddSeats($user_id_array,$ride_id);

        $seat = $this->getSeats($ride_id);

        
        if((int)$seat){
            $this->setAvaiable($ride_id);
        }


    }

    protected function jsonEncodeAndPostAddSeats($arr, $ride_id){

             $arr = array_values($arr);
             //encode it
             $arr = json_encode($arr);
 
             //update in db
             $this->db->query('UPDATE posts SET
             selected = :selected, seats = seats + 1 WHERE id=:rideid');
             $this->db->bind(':selected', $arr);
             $this->db->bind(':rideid', $ride_id);
     
             if ($this->db->execute()) {
                 return true;
             }
             return false;  
    }

    public function compareUserIdWithAllJsonId(){

        $user_ids = [];
        
        $this->db->query('SELECT * FROM posts');
        $results = $this->db->resultSet();

        foreach($results as $obj){
            $user_ids[$obj->id] = $this->getJsonDecodeOfSelected($obj->id);
        }

        $selected_ride_id = [];


        foreach($user_ids as $key => $value){
            foreach($value as $user_id){
                if((int)$_SESSION['user_id'] === $user_id){
                    $selected_ride_id[] = $key;
                }
            }
        }
        

        $selected_ride_id = array_unique($selected_ride_id);

        $ridesObj = [];

        foreach($selected_ride_id as $ride_id){
            $ridesObj[$ride_id] = $this->getRideById($ride_id);
        }

        return $ridesObj;
        
    }
    //current user le select gareko rides harulai dekhaonuparyo
    //current user ko id
    //tyo chai sab json format ko ids haru sanga compare garnu paryo
        //sab id haru collect garnu paryo
        //sab id ko json format ko id haru lai ride id sanga arry ma halna paryo
        //user id match garera tyo ride id obtain garnu paryo
        //tyo ride id ko data obtain garnu paryo 
    //match vayo vane arry ma push garnu paryo

    public function getRideSelectedUsers($ride_id){

        
        
        $user_ids = $this->getJsonDecodeOfSelected($ride_id);

        if( empty($user_ids)){
            return [];
        }

        
        $stmt = "";
        $i = 1;

        foreach( $user_ids as $id){
            $stmt .= " id=:id_".$i . " OR";
            $i++;
        }

        $stmt = substr($stmt, 0 , -3);

        $this->db->query('SELECT full_name,email FROM users  WHERE '.$stmt);
        
        $i = 1;

        foreach($user_ids as $id){
            $this->db->bind(':id_'.$i, $id);
            $i++;
        }

        $results = $this->db->resultSet();

        return $results;

    }

    public function getUserRideIds(){

        $ride_ids = [];

        $obj = $this->getUserRides();
        
        foreach($obj as $ride){
            $ride_ids[] = (int)$ride->id;
        }
        
        return $ride_ids;

    }

    public function distributeSelectedUsersByRideId(){

        $rideSelectedInfo = [];
        $ride_ids = $this->getUserRideIds();

        foreach($ride_ids as $id){
            $rideSelectedInfo[$id] = $this->getRideSelectedUsers($id);
        }
        
        return $rideSelectedInfo;
       
    }

    
}
