<?php

namespace App\Models\Compra;

use App\Models\Articulo\Articulo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor_Materiales extends Model
{
    use HasFactory;
    protected $table = "proveedor_materiales";
    public $timestamps = false;
    protected $fillable = [
        'proveedor_id',
        'material_id'
    ];

    

    public function material(){
        return $this->belongsTo(Articulo::class,'material_id');
    }
}
