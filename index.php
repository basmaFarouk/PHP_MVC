<?php

use Src\Http\Request;
use Src\Http\Response;
use Src\Http\Route;
use Src\Support\Arr;
use Src\Support\Config;

require_once __DIR__.'/src/Support/helpers.php';
require_once __DIR__.'./vendor/autoload.php';
require_once __DIR__.'/routes/web.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// var_dump($_ENV);
// var_dump(Route::$routes['get']['/']());
// $route= new Route(new Request,new Response);
// $route->resolve();
// dump($route->request->getMethod());
app()->run();

