<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datosistema extends Model
{
    use HasFactory;
    protected $fillable=['cobromensual','estado'];
}
