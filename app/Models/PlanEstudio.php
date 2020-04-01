<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    protected $table = 'plan_estudio';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;
}
