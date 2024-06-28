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
        'id',
        'articulo_id',
        'nombre',
        'apellido',
        'celular',
        'empresa',
    ];

    public function lista_materiales()
    {
        return $this->hasMany(Proveedor_Materiales::class, 'proveedor_id','id');
    }
    // public function lista_materiales(){
    //     return $this->belongsTo(Proveedor_Materiales::class,'material_id','id');
    // }
}
