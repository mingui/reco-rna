<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura_contenido extends Model
{
    protected $table = 'asignatura_contenido';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;

    public function asignaturas()
    {
    return $this->belongsTo('App\Models\Asignatura','asignatura_id');
    }

    public function contenidos()
    {
    return $this->belongsTo('App\Models\Contenido','contenido_id');
    }
}
