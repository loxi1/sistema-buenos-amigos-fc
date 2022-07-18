<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listaganadores extends Model
{
    use HasFactory;
    protected $fillable=['aperturaranio_id','aperturarmes_id','aperturarpartidos_id','asistenciapartidos_id','socios_id','monto_ganado'];
}
