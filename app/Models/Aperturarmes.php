<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aperturarmes extends Model
{
    use HasFactory;
    protected $fillable=['aperturaranio_id','mes','user_id','created_at','updated_at','estado'];
}
