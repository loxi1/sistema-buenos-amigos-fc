<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentaxcobrar extends Model
{
    use HasFactory;
    protected $fillable=['aperturaranio_id','aperturarpartidos_id','socios_id','tipo_movimiento_id','monto_cobrar','monto_cobrado','monto_pendiente','cobranzaestados_id','tipotarjeta_id','aperturarmes_id','asistenciapartidos_id','fecha_ingreso'];
}
