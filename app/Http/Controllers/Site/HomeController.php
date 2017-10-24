<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    

    public function index(){
        return view('site.home.index');
    }
    
    
    public function getContato(){
        return 'Página de contato do site';
    }
    
    public function getSobre(){
        return view('site.sobre.index');
    }
    
    public function missingMethod($parameters = array()) {
        echo view('site.404.index', compact('parameters'));
    }
}