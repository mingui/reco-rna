<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Busquedas;
use App\Models\Bibliografia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
          $salida = executar_python();   
          foreach($salida as $file){
              //echo $file . '<br>';
              var_dump($file);
          }

    
        
      // return view('home');
    }



}
