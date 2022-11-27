<?php

use App\Controllers\HomeController;
use Src\Http\Route;

// Route::get('/',function(){
//     echo 'hello';
// });

Route::get('/',[HomeController::class,'index']);