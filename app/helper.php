<?php


function get_ranking_medio($libro_id){
   $data = \App\Models\Busquedas::where('libro_id', $libro_id)->avg('ranking');

   if($data > 5){
       $data = 5;
   }

    return number_format($data, 2);
}


function get_planes($plan_id){

    $data = \App\Models\PlanEstudio::Find($plan_id);

    if(count($data) > 0){
        return $data->plan;
    }

    return '';
}


function get_nombre_contenido($id){

    return \App\Models\Contenido::Find($id)->tema;
}


function crear_datos_busquedas(){
    $raitings = Busquedas::orderBy('user_id')->select('user_id', 'libro_id', 'ranking', 'created_at')->get();

   
   $csvExporter = new \Laracsv\Export();
   $csvExporter->build($raitings, ['user_id', 'libro_id', 'ranking', 'created_at'])->download();

}

function crear_datos_bibiografia(){
   
    $bibiografia = Bibliografia::orderBy('id')->select('id', 'titulo', 'autor1', 'autor2')->get();
   $csvExporter = new \Laracsv\Export();
   $csvExporter->build($bibiografia, ['id', 'titulo', 'autor1', 'autor2'])->download();
}


function executar_python(){
    $salida= array(); //recogerá los datos que nos muestre el script de Python
 
    $data = exec("python  libros.py", $salida);
  
   return $salida;
}