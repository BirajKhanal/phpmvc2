<?php

class Input{
    public static function sanitize($dirty){
        return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }

    public static function get($input){
        if(isset($_POST[$input])){
            $_POST = filter_input_array(INPUT_POST , FILTER_SANITIZE_STRING);
            return self::sanitize($_POST[$input]);
        } else if(isset($_GET[$input])){
            return self::sanitize($_GET[$input]);
        }
    }
}