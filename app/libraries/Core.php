<?php

/*
    *app core class
    *loads controllers from the url , creates url
    *url format - /controller/method/params
    */
class Core
{

    protected $currentController = 'Pages'; //default controller
    protected $controller_name = ''; //default controller

    protected $currentMethod = 'index'; //default method
    protected $params = []; //default parameters are empty

    

    public function __construct()
    {
        //print_r($this->getUrl());
        $url = $this->getUrl();
        
        //this is for acl
        $this->controller_name = ucwords($url[0]);

        //look in controller for first value
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

            //if exists , set as controller
            $this->currentController = ucwords($url[0]);

            //removes 0 index coz its job is done
            unset($url[0]);
        }


        //require the controller , two dots because this is actually in public/index.php
        require_once '../app/controllers/Restricted.php';
       
        require_once '../app/controllers/' . $this->currentController . '.php';


        //check for second part of the url
        if (isset($url[1])) {
            //check if the method exists in current controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                //removes 1 index , its job is done
                unset($url[1]);
            }
        }

        //acl
        // acl check
        $grantAccess = self::hasAccess($this->controller_name, $this->currentMethod);

        if (!$grantAccess) {
            $this->currentController = 'restricted';
            $this->currentMethod = 'index';
        }

        //get params , if there are any 
        if ($url) {
            $this->params = array_values($url); //returns values of the array
        } else {
            $this->params = [];
        }

        //! instantiate the controller class - this is important
        $this->currentController = new $this->currentController;

        //callback function , calls user defined function in a class with multiple params(array of params)
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    public function getUrl()
    {
        // if url exists
        if (isset($_GET['url'])) {
            // removes excess '/' from right side of url
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url); //stores in an array
            return $url;
        }
        return ['Pages'];
    }

     /**
     * gets acl.json decodes and puts array data in $acl
     * sets default user to guest
     * sets default grant acess to false
     * if session exists logs in user and add/remove permission in necessary pages as stated in acl.jason
     * returns grantAcess variable 
     */
    public static function hasAccess($controller_name, $action_name)
    {
        $acl_file = file_get_contents(ROOT.'/libraries/acl.json');
        //acl array stored here
        $acl = json_decode($acl_file, true);
        //dnd($acl);
        
        $current_user_acls = ["Guest"];
        $grantAccess = false;
        //FOR LOG IN 
        
        if (isset($_SESSION) && !empty($_SESSION)) {
            $current_user_acls[] = "LoggedIn";
           // dnd($current_user_acls);
        }

        foreach ($current_user_acls as $level) {
            if (array_key_exists($level, $acl) &&
                array_key_exists($controller_name, $acl[$level])) {
                if (in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
                    $grantAccess = true;
                    break;
                }
            }
        }
        //denied
        foreach ($current_user_acls as $level) {
            $denied = $acl[$level]['denied'];
            if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
                $grantAccess = false;
                break;
            }
        }
        return $grantAccess;
    }
}
