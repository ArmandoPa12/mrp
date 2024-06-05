<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;
    protected $table = 'proceso';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
