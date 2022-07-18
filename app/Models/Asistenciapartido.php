<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistenciapartido extends Model
{
    use HasFactory;
    protected $fillable=['aperturarpartidos_id','socios_id','es_ganador','estado'];
}
