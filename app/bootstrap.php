<?php

//gives the path to the root of our file system
define('ROOT', dirname(__FILE__));

//load configuration files
require_once 'config/config.php';

//helper functions
require_once 'helpers/helper.php';

// load library files
/* require_once 'libraries/Controller.php';
    require_once 'libraries/Core.php';
    require_once 'libraries/Database.php'; */

//autoload core libraries
spl_autoload_register(function ($className) {
    if (file_exists(ROOT . '/libraries/' . $className . '.php')) {
        require_once 'libraries/' . $className . '.php';
    }
});
