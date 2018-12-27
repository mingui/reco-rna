<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{
    protected $table = 'bibliografia';

    protected $guarded= ['_token', 'salir' ]; // every field to protect

    public $timestamps = false;
}
