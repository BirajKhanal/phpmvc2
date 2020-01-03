<?php
    // default class , //we can extend controller because we are actually in index.php then bootstrap.php 
    class Pages extends Controller{

        public function __construct(){
            //load model
            $this->rideModel = $this->model('Ride');
        }

        //default method
        public function index(){
            $rides = $this->rideModel->getRides();

            $data = [
                'title' => 'welcome to ride share',
                'rides' => $rides
            ];
        
            $this->view('pages/index' , $data);
        }

        public function about(){
            $this->view('pages/about');
        }

    }