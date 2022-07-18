<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentasxcobrardetalle extends Model
{
    use HasFactory;
    protected $fillable=['cuentaxcobrars_id','monto_cobrado','fecha_ingreso','estado'];
}
