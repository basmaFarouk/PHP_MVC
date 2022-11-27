<?php

namespace Src\Http;

use Src\View\View;

class Route{
    public $request;
    protected $response;
    public static array $routes=[];

    public function __construct(Request $request,Response $response)
    {
        $this->request=$request;
        $this->response=$response;
    }

    public static function get($route, callable|array|string $action){
        self::$routes['get'][$route]=$action;
    }

    public static function post($route, callable|array|string $action){
        self::$routes['post'][$route]=$action;
    }

    public function resolve(){
        $method=$this->request->getMethod();
        $path=$this->request->path();
        $action=self::$routes[$method][$path] ?? false;

        if(!array_key_exists($path,self::$routes[$method])){
            View::makeError('404');
        }

        if(is_callable($action)){
            call_user_func_array($action,[]);
        }

        if(is_array($action)){
            call_user_func_array([new $action[0],$action[1]],[]);
        }
    }
}