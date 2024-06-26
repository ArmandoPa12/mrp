<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $table = 'permiso';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre'
    ];

    public function roles(){
        return $this->belongsToMany(Rol::class,'rol_permiso','permiso_id','rol_id');
    }
}
