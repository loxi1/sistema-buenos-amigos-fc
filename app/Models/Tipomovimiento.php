<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipomovimiento extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['tipomovimientos','abreviatura','padre_id','tipo','estado'];
}
