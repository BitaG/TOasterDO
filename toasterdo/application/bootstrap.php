<?php
/*-- Core --*/
require_once 'core/view.php';
require_once 'core/controller.php';

/*-- Includes--*/
require_once 'config.php';
require_once 'includes/class-database.php';
require_once 'includes/functions.php';
require_once 'core/route.php';

require_once 'includes/class-Auth.php';
Auth::start ( Route::get_routes() );

$route = new Route;
