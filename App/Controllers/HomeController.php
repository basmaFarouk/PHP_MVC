<?php
namespace App\Controllers;

use Src\View\View;

class HomeController{
    public function index(){
        // return View::make('home');
        return view('home');
    }
}