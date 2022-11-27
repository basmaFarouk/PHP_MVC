<?php
namespace Src;

use Src\Http\Request;
use Src\Http\Response;
use Src\Http\Route;
use Src\Support\Config;

class Application{

    protected Route $route;
    protected Request $requset;
    protected Response $response;
    protected Config $config;

    public function __construct()
    {
        $this->requset=new Request;
        $this->response=new Response;
        $this->route=new Route($this->requset,$this->response);
        $this->config=new Config($this->loadConfiguration());
    }

    public function run(){
        $this->route->resolve();
    }

    public function __get($name)
    {
        if(property_exists($this,$name)){
            return $this->$name;
        }
    }

    protected function loadConfiguration(){

        // var_dump(scandir(configPath()));
        foreach(scandir(configPath()) as $file){
            if($file=='.' || $file=='..'){
                continue;
            }

            $fileName=explode('.',$file)[0]; //[app,php]
            yield $fileName => require configPath().$file;
        }
    }
}