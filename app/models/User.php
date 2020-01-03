<?php
    class User{
        private $db;
        public function __construct(){
            $this->db =  new Database;
        }

      
        //find whether user with same email exists
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
  
            $row = $this->db->single();
  
        // Check row
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
      }

      public function login($email , $password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        $hashed_password = $row->password ;
        if(password_verify($password , $hashed_password)){
          return $row;
        }else{
          return false;
        }
      }

      //register user
      public function register($data){

        $this->db->query('INSERT INTO users (full_name,email, password) VALUES (:full_name, :email, :password)');
        
        $this->db->bind(':full_name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

      }    
 }