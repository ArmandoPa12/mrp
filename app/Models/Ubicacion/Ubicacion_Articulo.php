<?php

namespace App\Models\Ubicacion;

use App\Models\Articulo\Articulo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion_Articulo extends Model
{
    use HasFactory;
    protected $table = 'ubicacion_articulo';
    public $timestamps = false;
    protected $fillable = [
        'estante_id',
        'articulo_id',
        'fila',
        'cant_articulo',
    ];

    public function estante(){
        return $this->belongsTo(Estante::class);
    }
    public function articulo(){
        return $this->belongsTo(Articulo::class);
    }

}
