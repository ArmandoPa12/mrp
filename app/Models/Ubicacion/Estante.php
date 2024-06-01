<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    use HasFactory;
    protected $table = 'estante';
    public $timestamps = false;
    protected $fillable = [
        'ubicacion_id', 
        'cant_fila'
    ];

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class,'ubicacion_id');
    }
}
