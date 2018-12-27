<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignatura';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;
}
