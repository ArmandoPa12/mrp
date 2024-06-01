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
        'photo',
        'correo',
        'username',
        'password',
        'token_reset',
        'token_expires_at',
        'password_reset_at'
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
        return 'name_value';
     }


}
