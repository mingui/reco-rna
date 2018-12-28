<?php

namespace App\Http\Controllers;

use App\Models\Busquedas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{



    public function index(Request $request){

        if($request->test_rna){
            return $this->rna_1(1, 0,  1,  0.98888,  $this->rnq_2());
        }

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

        $actual = Busquedas::where('user_id', Auth::user()->id)
                            ->where('tema', $request->q)
                            ->whereBetween('created_at', [ date('Y-m-d'). ' 00:00:00', date('Y-m-d'). ' 23:59:59'   ])
                            ->count();

        if(!$actual > 0){
            $data = new Busquedas();
            $data->user_id = Auth::user()->id;
            $data->tema    = $request->q;
            $data->save();
            return $data->id;
        }

        return 0;

    }





    public function calificar(Request $request){

        $data = Busquedas::Find($request->busqueda_id);
        $data->libro_id = $request->libro_id;
        $data->ranking    = $request->ranking;
        if($data->save()){
            session()->flash('success', 'Gracias por tu calificacion :)');

        }

        return redirect()->back();


    }



    public function rna_1($E1, $E2,  $P1,  $P2,  $U){

        $S = ( $E1 * $P1 + $E2 * $P2 + 1 * $U);

        return $S;
    }



    public function rnq_2(){

        $datos = array( [ 1, 1, 1 ], [ 1, 0, 0 ], [ 0, 1, 0 ], [ 0, 0, 0 ] ); //Tabla de verdad AND

       // rand(-1, 9)  =  rand(-1, 9);

        $pesos = array( number_format(rand(-1, 1).'.'.rand(), 2, '.', ''), number_format(rand(-1, 1).'.'.rand(), 2, '.', ''), number_format(rand(-1, 1).'.'.rand(), 2, '.', '') ); //Inicia los pesos al azar

        $aprendiendo = false;

        $salidaEntera =0;
        $iteracion = 0;

        while ($aprendiendo){ //Hasta que aprenda la tabla AND
               $iteracion++;
               $aprendiendo = false;
                for ($cont = 0; $cont <= 3 ; $cont++){
                    $salidaReal =  ($datos[$cont][0] * $pesos[0] + $datos[cont][1] * $pesos[1] + $pesos[2]); //Calcula la salida real

                        if($salidaReal>0) $salidaEntera = 1; else $salidaEntera = 0; //Transforma a valores 0 o 1

                         if($salidaEntera != $datos[$cont][2]) {
                                //Si la salida no coincide con lo esperado, cambia los pesos al azar
                             $pesos[0] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '') - number_format(rand(-1, 1).'.'.rand(), 2, '.', '');
                             $pesos[1] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '') - number_format(rand(-1, 1).'.'.rand(), 2, '.', '');
                             $pesos[2] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '') - number_format(rand(-1, 1).'.'.rand(), 2, '.', '');
                             $aprendiendo = true; //Y sigue buscando
                            }

                    $pesos[0] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '') - number_format(rand(-1, 1).'.'.rand(), 2, '.', ''); $pesos[1] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '') - number_format(rand(-1, 1).'.'.rand(), 2, '.', '');
                    $pesos[2] = number_format(rand(-1, 1).'.'.rand(), 2, '.', '')- number_format(rand(-1, 1).'.'.rand(), 2, '.', '');
                    $aprendiendo = true; //Y sigue buscando
            }
        }
        print_r("Iteraciones: " . $iteracion); echo '<br>';
        print_r("Peso 1: " . $pesos[0]); echo '<br>';
        print_r("Peso 2: " . $pesos[1]); echo '<br>';
        print_r("Peso 3: " . $pesos[2]); echo '<br>';


        for ($cont = 0; $cont <= 3; $cont++){ //Muestra el perceptron con la tabla AND aprendida

                    $salidaReal = ($datos[$cont][0] * $pesos[0] + $datos[$cont][1] * $pesos[1] + $pesos[2]);

                    if ($salidaReal > 0) $salidaEntera = 1; else $salidaEntera = 0;

                    print_r("Entradas: " . $datos[$cont][0] . " y " . $datos[$cont][1] . " = " . $datos[$cont][2] . " perceptron: " .$salidaEntera);
            echo '<br>';

        }



}


}
