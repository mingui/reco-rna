<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = 'contenido';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;
}
