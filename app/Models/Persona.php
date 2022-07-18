<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['nombres','apellidos','sexo','tipo_documentos_id','numero_documento','fecha_nacimiento','celular','departamentos_id','provincias_id','distritos_id','direccion','referencia'];
}
