<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentaxpagar extends Model
{
    use HasFactory;
    protected $fillable=['aperturarpartidos_id','tipo_movimiento_id','monto_pagar','monto_pagado','monto_pendiente','pagoestados_id','fecha_ingreso','estado'];
}
