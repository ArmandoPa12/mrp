<?php

namespace App\Models\Articulo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Articulo extends Model
{
    use HasFactory;
    protected $table = 'tipo_articulo';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre'
    ];
}
