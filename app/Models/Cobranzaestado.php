<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranzaestado extends Model
{
    use HasFactory;
    protected $fillable=['estadopagos','estadocobros','estado'];
}
