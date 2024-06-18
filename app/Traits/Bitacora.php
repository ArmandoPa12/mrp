<?php 
namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

trait Bitacora
{
    public function logBitacora($action,$entidad,$status,$entidadId,$header)
    {
        try {
            
            $datos = [
                'user_id' => $header['user-id'][0] ?? '---',
                'username' => $header['username'][0] ?? '----',
                'user_role' => $header['rol-id'][0] ?? '----',
                'action' => $action,
                'entity' => $entidad,
                'ip_address' => $header['host'][0] ?? 'EMPTY',
                'status' => $status,
                'entidad_id' => $entidadId,
                'location' => $header['location'][0] ?? '-----',
            ];


            $response = Http::post('http://localhost:8081/api/test', [
                'data' => $datos,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
           
            return false;
        }
    }
    public function crearBitacoraExitosa($entidad,$entidadId,$header){
        $this->logBitacora('CREAR',$entidad,'EXITOSO',$entidadId,$header);
    }
    public function actualizarBitacoraExitosa($entidad,$entidadId,$header){
        $this->logBitacora('ACTUALIZAR',$entidad,'EXITOSO',$entidadId,$header);
    }
    public function eliminarBitacoraExitosa($entidad,$entidadId,$header){
        $this->logBitacora('ELIMINAR',$entidad,'EXITOSO',$entidadId,$header);
    }
    public function verBitacoraExitosa($entidad,$entidadId,$header){
        $this->logBitacora('VER',$entidad,'EXITOSO',$entidadId,$header);
    }
    public function verListaBitacoraExitosa($entidad,$entidadId,$header){
        $this->logBitacora('VER LISTA',$entidad,'EXITOSO',$entidadId,$header);
    }
}
