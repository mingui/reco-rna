<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibliografia_contenido extends Model
{
    protected $table = 'bibliografia_contenido';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;

    public function bibliografias()
    {
    return $this->belongsTo('App\Models\Bibliografia','bibliografia_id');
    }

    public function contenidos()
    {
    return $this->belongsTo('App\Models\Contenido','contenido_id');
    }
}
