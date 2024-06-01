<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    protected $table = 'ubicacion';
    public $timestamps = false;
    protected $fillable = [
        'tipo_id',
        'direccion',
        'cant_estantes'
    ];

    public function tipoUbicacion(){
        return $this->belongsTo(Tipo_Ubicacion::class,'tipo_id');
    }

}
