<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentasxpagardetalle extends Model
{
    use HasFactory;
    protected $fillable=['cuentaxpagars_id','monto_pagado','fecha_ingreso','estado'];
}
