<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;
    protected $table = 'usuario';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rol_id',
        'persona_id',
        'username',
        'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function rol(){
        return $this->belongsTo(Rol::class);
    }
    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    // public function setPassword($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }
    public function username() {
        return 'username';
     }


}
