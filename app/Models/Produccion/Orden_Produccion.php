<?php

namespace App\Models\Produccion;

use App\Models\Usuario\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden_Produccion extends Model
{
    use HasFactory;
    protected $table = "orden_produccion";
    public $timestamps = false;
    protected $fillable = [
        'usuario_id_ge',
        'usuario_id_tr',
        'estado_produccion_id',
        'fechar_hora'
    ];
    /**
     * Get the usuarioGenerado that owns the Orden_Compra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioGenerado()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id_gen');
    }
    public function usuarioTrabajador()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id_tr');
    }
    public function estadoProduccion()
    {
        return $this->belongsTo(Estado_Produccion::class, 'estado_produccion_id');
    }

}
