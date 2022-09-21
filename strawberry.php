<?php

use Kenjiefx\StrawberryFramework\App;

/**
*
* NOTE: Strawberry Framework is not meant to be a server-side
* rendering framework so the  preview module should not be used
* in production
*
**/

define('ROOT',__DIR__);
require ROOT.'/vendor/autoload.php';

ini_set('error_reporting','E_ALL');
ini_set( 'display_errors','1');
error_reporting(E_ALL ^ E_STRICT);

$app = new App();
$app->run();

