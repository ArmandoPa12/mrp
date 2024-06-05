<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_Produccion extends Model
{
    use HasFactory;
    protected $table = 'estado_orden_produccion';
    public $timestamps = false;
    protected $fillable = [
        'descripcion'
    ];
}
