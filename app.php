<?php

    require_once 'vendor/autoload.php';
    //require_once APPPATH . 'install/migration.php';

    $url = explode("&", trim($_SERVER['REQUEST_URI'], '/'));

    if($_SERVER['REQUEST_URI'] != "") {
        switch($url[1]) {
            case "steep=1":
                require_once 'application/install/pages/check.php';
                break;

            case "steep=2":
                require_once 'application/install/pages/check.php';
                break;

            case "steep=3":
                require_once 'application/install/pages/check.php';
                break;

            case "steep=4":
                require_once 'application/install/pages/check.php';
                break;
        }
    }