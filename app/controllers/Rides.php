<?php
class Rides extends Controller
{

    public function __construct()
    {
        //loading model
        $this->rideModel = $this->model('Ride');
    }

    //default method for rides controller
    public function index()
    {

        $current_selected_rides = $this->rideModel->compareUserIdWithAllJsonId();

        $selected_users = $this->rideModel->distributeSelectedUsersByRideId();

        //get posts
        $rides = $this->rideModel->getUserRides();

        $data = [
            'rides' => $rides,
            'selected_users' => $selected_users,
            'current_selected_rides' => $current_selected_rides
        ];
        $this->view('rides/index', $data);
    }


    //add rides
    public function add()
    {

        $validation = new Validation;

        //validation rules
        $validation_rules = [
            'source' => [
                'display' => 'Source',
                'required' => true,
                'max' => 20
            ],
            'destination' => [
                'display' => 'Destination',
                'required' => true,
                'max' => 20
            ],
            'departure' => [
                'display' => 'departure',
                'required' => true,
            ],
            'vehicle' => [
                'display' => 'vehicle',
                'required' => true,
                'max' => 20
            ],
            'seats' => [
                'display' => 'Seats',
                'required' => true,
                'max' => 20,
                'is_numeric' => true,
                'is_positive' => true
            ],
            'contact' => [
                'display' => 'Contact',
                'required' => true,
                'max' => 20,
                'is_numeric' => true
            ],
            'vehicle_id' => [
                'display' => 'Vehicle Id',
                'required' => true,
                'max' => 20,
            ],
        ];

        //post init
        $rides = [
            'source' => '',
            'destination' => '',
            'departure' => '',
            'vehicle' => '',
            'seats' => '',
            'contact' => '',
            'vehicle_id' => ''
        ];

        if ($_POST) {

            //process request to add ride

            //check validation
            $validation->check($_POST, $validation_rules);

            //check all errors are empty
            if ($validation->passed()) {

                //insert the data
                if ($this->rideModel->addRide($_POST)) {
                    redirect('rides');
                } else {
                    $validation->addError("Could not add Rides");
                }
            }

            $rides = [
                'source' => trim($_POST['source']),
                'destination' => trim($_POST['destination']),
                'departure' => trim($_POST['departure']),
                'vehicle' => trim($_POST['vehicle']),
                'seats' => trim($_POST['seats']),
                'contact' => trim($_POST['contact']),
                'vehicle_id' => trim($_POST['vehicle_id'])
            ];
        }

        $data = [
            'rides' => $rides,
            'display_error' => $validation->displayErrors()
        ];

        $this->view('rides/add', $data);
    }

    public function delete($ride_id)
    {
        if ($this->rideModel->deleteRide($ride_id)) {
            redirect('rides');
        } else {
            die('Something went wrong !!');
        }
    }

    public function update($ride_id)
    {

        $validation = new Validation;
        
        //validation rules
        $validation_rules = [
            'source' => [
                'display' => 'Source',
                'required' => true,
                'max' => 20
            ],
            'destination' => [
                'display' => 'Destination',
                'required' => true,
                'max' => 20
            ],
            'departure' => [
                'display' => 'departure',
                'required' => true,
            ],
            'vehicle' => [
                'display' => 'vehicle',
                'required' => true,
                'max' => 20
            ],
            'seats' => [
                'display' => 'Seats',
                'required' => true,
                'max' => 20,
                'is_numeric' => true,
                'is_positive' => true
            ],
            'contact' => [
                'display' => 'phone number',
                'required' => true,
                'max' => 20,
                'is_numeric' => true
            ],
            'vehicle_id' => [
                'display' => 'Vehicle Id',
                'required' => true,
                'max' => 20,
            ],
        ];

        //bring previous rides data from model
        $result = $this->rideModel->getRideById($ride_id);

        //init rides
        $rides = [
            'rideid' => $result->id,
            'source' => $result->source,
            'destination' => $result->destination,
            'departure' => $result->departure,
            'vehicle' => $result->vehicle,
            'seats' => $result->seats,
            'contact' => $result->contact,
            'vehicle_id' => $result->vehicle_id
        ];

        //see if user id match with current session holder's id
        $user_ride_id = $this->rideModel->checkUserSession($ride_id);

        if ($user_ride_id->user_id !== $_SESSION['user_id']) {
            redirect('rides');
        }

        if ($_POST) {
            //check validation
            $validation->check($_POST, $validation_rules);

            if($validation->passed()){
                if ($this->rideModel->updateRide($_POST)) {
                    redirect('rides');
                } else {
                    $validation->addError('Something went wrong!!');
                }
            }
        } 

        //data passing to view
            $data = [
                'rides' => $rides,
                'display_error' => $validation->displayErrors()
            ];

            $this->view('rides/update', $data);
        
    }

    public function select($ride_id){
        
        if(!($this->rideModel->selectRide($ride_id))){
            dnd("Somthing went wrong");
        }

        redirect(' ');

    }

    public function removeSelected($ride_id){
        $this->rideModel->removeSelected($ride_id);
        redirect("rides");
    }

}
