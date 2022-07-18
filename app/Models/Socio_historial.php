<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio_historial extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['socio_id','persona_id','tiposocios_id','aperturaranio_id','anio','fecha_ingreso'];
}
