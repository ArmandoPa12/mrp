<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'persona';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
        'apellido_p',
        'apellido_m',
        'correo',
        'nacimiento',
        'celular',
        'imagen'
    ];
}
