<?php

// Include autoload
require_once 'vendor/autoload.php';

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */

$app = new Core\Application();
$app->register();


var_dump(app());