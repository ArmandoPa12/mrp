<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'rol';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
        'descripcion'
    ];
    public function permisos(){
        return $this->belongsToMany(Permiso::class,'rol_permiso','rol_id','permiso_id');
    }
}
