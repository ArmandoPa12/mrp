<?php

namespace App\Http\Controllers\Proceso;

use App\Http\Controllers\Controller;
use App\Models\Proceso\Proceso;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    use Bitacora;
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dato = Proceso::all();
        $this->verListaBitacoraExitosa('PROCESO',null,$request->header());
        return $this->successResponse($dato,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proceso = Proceso::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion']
        ]);
        $this->crearBitacoraExitosa('PROCESO',$proceso->id,$request->header());
        return $this->successResponse($proceso,'creado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proceso $proceso)
    {
        try{
            $proceso->update([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion']
            ]);
            $this->actualizarBitacoraExitosa('PROCESO',$proceso->id,$request->header());
            return $this->successResponse($proceso,'actualizado');
        }catch(\Exception $e){
    
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Proceso $proceso)
    {
        try{
            $c = $proceso->id;
            $proceso->delete();
            $this->eliminarBitacoraExitosa('PROCESO',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
