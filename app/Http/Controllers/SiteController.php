<?php

namespace App\Http\Controllers;

use App\Models\Bibliografia;
use App\Models\Busquedas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{



    public function index(Request $request){

        $title = 'Biblioteca';
        $data = $this->filtro($request);
        $busqueda_id = 0;
        if($request->q != ''){
            $busqueda_id = $this->guardar_busqueda($request, null, null);
        }


        return view('index', compact('data', 'title', 'request', 'busqueda_id'));
    }






    public function filtro($request){

        $data = DB::table('bibliografia')
//            ->leftJoin('product_category', 'product_category.product_id', '=', 'product.id')

            ->where(function ($query) use ($request)
            {


                if ($request->q) {
                    $query->where(DB::raw('CONCAT(titulo, autor1, autor2)'), 'like', '%' .$request->q. '%');
                }




            })
           // ->select('bibliografia*')
           // ->groupBy('product.id')
            ->orderBy('titulo')
            ->paginate(30);
        return $data;


    }



    public function guardar_busqueda($request, $libro_id=null, $ranking=null){

        $data = new Busquedas();
        $data->user_id = Auth::user()->id;
        $data->tema    = $request->q;
        $data->save();
        return $data->id;

    }





    public function calificar(Request $request){

        $data = Busquedas::Find($request->busqueda_id);
        $data->libro_id = $request->libro_id;
        $data->ranking    = $request->ranking;
        if($data->save()){
            session('success', 'Gracias por tu calificacion :)');

        }

        return redirect()->back();


    }



}
