<?php

namespace Src\Support;

use ArrayAccess;

class Arr{

  // only(["userName"=>"Ahmed","email"=>"test@t.com","age"=>5],'email') ;
    public static function only($array,$keys){
        return array_intersect_key($array,array_flip((array) $keys));
    }

    public function except($array,$keys){
        return static::forget($array,$keys);
    }

    public function flatten($array,$depth=INF){ //for multidimentional array

        $result=[];
        foreach($array as $item){
            if(!is_array($item)){
                $result[]=$item;
            }elseif($depth==1){
                $result=array_merge($result,array_values($item));
            }else{
                $result=array_merge($result,static::flatten($item,$depth-1));
            }
        }
    }


    public static function get($array,$key,$default=null){
        if(!static::accessible($array)){
            return value($default);
        }

        if(is_null($key)){
            return $array;
        }

        if(static::exists($array,$key) && !str_contains($key,'.')){
            return $array[$key] ?? value($default);
        }

        // if(!str_contains($key,'.')){
        //     return $array[$key] ?? value($default);
        // }

        foreach(explode('.',$key) as $segment){
            if(static::accessible($array,$key) && static::exists($array,$segment)){
                $array=$array[$segment];
            }else{
                return value($default);
            }
        }

        return $array;
    }


    public static function set(&$array,$key,$value){

        if(is_null($key)){
            return array_push($array,$value);
        }

        $keys=explode('.',$key);
        while(count($keys) > 1){
            $key=array_shift($keys);
            $array=&$array[$key];
        }

        // var_dump($keys);
        // exit;
        $array[array_shift($keys)]=$value;
        return $array;
    }

    public static function unset($array,$key){
        static::set($array,$key,null);
    }

    //to remove a  value from an array
    public static function forget(&$array,$keys){
        $original=&$array;
        $keys=(array)$keys; //['db.connections.default']


        if(!count($keys)){
            return;
        }

        foreach($keys as $key){ //if keys like array
            if(static::exists($array,$key)){
                unset($array[$key]);
                continue;
            }

            $parts=explode('.',$key); //['database','connections','default'];
            while(count($parts) > 1){
                $part=array_shift($parts);
                //'db'=>['connections']
                if(isset($array[$part]) && is_array($array[$part])){
                    $array=&$array[$part];
                    // var_dump($array);
                    // exit;

                }else{
                    continue;
                }
            }

            // var_dump($array);
            // exit;
            unset($array[array_shift($parts)]);
        }
    }

    public static function accessible($value){
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists($array,$key){

        if($array instanceof ArrayAccess){
            return $array->offsetExists($key);
        }

        return array_key_exists($key,$array);
    }

    //var_dump(Arr::has(['db'=>['connection' => ['default'=>'mysql']]], 'db.connection.default'))

    public static function has($array,$keys){

        if(is_null($keys)) return false;
        
        $keys= (array)$keys; //['db.connections.default']

        if($keys==[]) return false;

        foreach($keys as $key){
            //Arr::has($this->items,'database.connections.default')
            $subArray=$array;
            if(static::exists($array,$key)){
                continue;
            }

            foreach(explode('.',$key) as $segment){
                if(static::accessible($subArray) && static::exists($subArray,$segment)){
                    $subArray=$subArray[$segment];
                }else{
                    return false;
                }
            }
        }

        return true;
    }


    public static function last($array, callable $callback=null, $default=null){

        if(is_null($callback)){
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array,true), $callback, $default);
    }


    public static function first($array, callable $callback=null, $default=null){

        if(is_null($callback)){
            if(empty($array)){
                return value($default);
            }
            foreach($array as $item){ //for indexed and associative array return only the first item
                return $item; 
            }
        }

        foreach($array as $key=>$value){
            if(call_user_func($callback,$value,$key)){ //three,2
                // var_dump($key,$value);
                // exit;
                return $value;
            }
        }

        return value($default);

    }
}