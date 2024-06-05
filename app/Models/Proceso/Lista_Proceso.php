<?php

namespace App\Models\Proceso;

use App\Models\Articulo\Articulo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Lista_Proceso extends Pivot
{
    protected $table = 'lista_proceso';
    public $timestamps = false;
    protected $fillable = [
        'paso',
        'tiempo',
        'proceso_id',
        'producto_id'
    ];
    public function proceso(){
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }
    public function producto(){
        return $this->belongsTo(Articulo::class,'producto_id');
    }
}
