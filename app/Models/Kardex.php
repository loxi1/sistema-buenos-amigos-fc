<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $fillable=['tipomovimientos_id','tipo','abreviatura','documento_id','monto','saldo_actual','estado'];
}
