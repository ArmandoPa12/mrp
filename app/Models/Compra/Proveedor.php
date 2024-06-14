<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = "proveedor";
    public $timestamps = false;
    protected $fillable = [
        'articulo_id',
        'nombre',
        'apellido',
        'celular',
        'empresa',
    ];
}
