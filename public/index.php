<?php

use Src\Http\Request;
use Src\Http\Response;
use Src\Http\Route;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../routes/web.php';
// var_dump(Route::$routes['get']['/']());
$route= new Route(new Request,new Response);
dump($route->request->path());