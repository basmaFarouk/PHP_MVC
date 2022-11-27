<?php
namespace Src\Support;


// var_dump(Arr::has(['db'=>['connection' => ['default'=>'mysql']]], 'db.connection.default'));
///////////////////////////////////////
$arr=[
    'db'=>[
        'connections'=>[
            'default'=>'mysql'
        ]
    ]
        ];
Arr::forget($arr,'db.connections.default');
// var_dump($arr);
///////////////////////////////////////
$arr=['db'=>['connections'=>['default'=>'mysql','secondary'=>'sqllite']]];
// var_dump(Arr::get($arr,'db.connections.secondary'));
///////////////////////////////////////////
// var_dump(Arr::last(['one','two','three'], function($item){
//     return (strlen($item) > 3);
// }));
///////////////////////////////////////////////
$arr=['db'=>['connections'=>['primary'=>'mysql','secondary'=>'sqllite']]];
// var_dump(Arr::set($arr,'db.connections.primary','postgrl'));
$arr=['db'=>['connections'=>['primary'=>'mysql','secondary'=>'sqllite']]];
$config=new Config(['db'=>['connections'=>['host'=>'localhost']]]);
// var_dump($config->get(['db','test']));
// var_dump($config->get('db.connections'));
// var_dump(app()->config);