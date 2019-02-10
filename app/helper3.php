<?php




function userLibrosInArray(){
    $data = \App\Models\UserLibros::where('user_id', auth()->user()->id)->pluck('libro_id')->toArray();

    return $data;
}


function getLibroData($id){
    if($id > 0){
        return \App\Models\Bibliografia::Find($id);
    }

    return false;
}

function getNombreLibro($id){
    if($id > 0){
        $data = \App\Models\Bibliografia::Find($id);
        if($data){
            return $data->titulo;
        }
    }

    return '';
}


function getBusquedaDetail($id){
    if($id > 0){
        return \App\Models\Busquedas::Find($id);
    }

    return false;
}

?>