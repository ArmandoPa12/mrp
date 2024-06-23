<?php

namespace App\Models\Compra;

use App\Models\Usuario\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden_Compra extends Model
{
    use HasFactory;
    protected $table = "orden_compra";
    public $timestamps = false;
    protected $fillable = [
        'usuario_id_gen',
        'usuario_id_ges',
        'proveedor_id',
        'estado_compra_id',
        'fecha_hora',
        'pdf_data',
        'file_name',
        'mime_type'
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
    public function usuarioGestor()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id_ges');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    public function estadoCompra()
    {
        return $this->belongsTo(Estado_Orden_Compra::class, 'estado_compra_id');
    }
    
}
