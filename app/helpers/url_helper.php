<?php
    //function to redirect url
    function redirect($page){
        header('location:'.URLROOT.$page);
    }