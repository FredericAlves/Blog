<?php
/**
 * Frédéric - Projet 3 - Formation OpenClassrooms - 14/06/17 18:51
 *
 * index
 */


require_once __DIR__.'/../vendor/autoload.php';

// intialize a new silex application object
$app = new Silex\Application();

// load the config file
require __DIR__.'/../app/config/dev.php';

// load the settings
require __DIR__.'/../app/app.php';

// load the roads
require __DIR__.'/../app/routes.php';

//run the application
$app->run();
$app['debug'] = true;