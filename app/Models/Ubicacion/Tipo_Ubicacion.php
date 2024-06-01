<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Ubicacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_ubicacion';
    public $timestamps =false;
    protected $fillable = [
        'nombre'
    ];
}
