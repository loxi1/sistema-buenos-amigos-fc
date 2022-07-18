<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aperturarpartido extends Model
{
    use HasFactory;
    protected $fillable=['aperturarmes_id','fecha_partido','monto_recaudado','monto_para_club','monto_para_apuesta','arbitro_id','pago_arbitraje','cancha_id','pago_cancha','cantidad_horas','user_id','estado'];
}
