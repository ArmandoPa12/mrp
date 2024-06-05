<?php

namespace App\Models\Articulo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $table = 'articulo';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_creacion',
        'fecha_vencimiento',
        'cantidad',
        'serie',
        'tipo_id',
        'imagen'
    ];
    public function materiales()
    {
        return $this->belongsToMany(Articulo ::class, 'lista_materiales', 'producto_id', 'material_id')
                ->withPivot('cantidad');;
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo_Articulo::class, 'tipo_id');
    }
}
