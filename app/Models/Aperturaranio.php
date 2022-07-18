<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aperturaranio extends Model
{
    use HasFactory;
    protected $fillable=['anio','user_id','created_at','updated_at','estado'];
}
