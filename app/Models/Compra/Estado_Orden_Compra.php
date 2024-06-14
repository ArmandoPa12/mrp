<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_Orden_Compra extends Model
{
    use HasFactory;
    protected $table = "estado_orden_compra";
    public $timestamps = false;
    protected $fillable = [
        'descripcion'
    ];
}
