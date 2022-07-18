<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;
    protected $fillable=['persona_id','tiposocios_id','aperturaranio_id','anio','created_at','updated_at'];
}
