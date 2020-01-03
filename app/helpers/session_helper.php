<?php
session_start();

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

//set session variables if the user successfully logs in
function createUserSession($data)
{
    $_SESSION['user_id'] = $data->id;
    $_SESSION['user_name'] = $data->full_name;
    $_SESSION['user_email'] = $data->email;
    redirect('pages');
}
