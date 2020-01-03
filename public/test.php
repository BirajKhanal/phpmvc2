<!-- 
/*  
    $params = [];
    $url = array('pages','about',33);
    print_r($url);
echo '<br>' ;
    unset($url[0]);

    print_r($url);
    echo '<br>' ;

    unset($url[1]);

    print_r($url);
    echo '<br>' ;

    if($url){
        $params = array_values($url);
        print_r($params);
    }else { 
        echo "doesn't contain" ;
    }
*/
<form action="test2.php">
    <input type="submit" value=>
</form> -->

<?php
//  $pattern = '/^[A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u';
//  $name = 'Avash Ghimire';
 
//  if(preg_match($pattern , $name)){
//     echo "match" ;
//  }else{
//      echo "no match";
//  }
/*
*connect to db
*bind values
*return rows or required results
*/
class Database{
    
    private $host = 'localhost'; 
    private $user = 'root';
    private $pass = '';
    private $dbname = 'rideshare';

    private $dbh; //db handler
    private $stmt; //statements
    private $error; //error message

    private $dsn;

    public function __constructor(){
        //set dsn
        
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname ;
        
         
        
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ); 

        try {
            //new pdo instance stored in database handler
            $this->dbh = new PDO($dsn , $this->user , $this->pass , $options);

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error ;
        }
        

    }   
    public function display(){
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname ;
        return $dsn;
    }
    //prepare statement with query
    public function query($sql){
        
        $this->stmt = $this->dbh->prepare($sql);
    
    }



}

