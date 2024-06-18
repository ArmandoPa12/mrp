<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ubicacion\StoreTipoUbicacionRequest;
use App\Http\Requests\Ubicacion\UpdateTipoUbicacionRequest;
use App\Models\Ubicacion\Tipo_ubicacion;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class TipoUbicacionController extends Controller
{
    use ApiResponse;
    use Bitacora;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Tipo_ubicacion::orderBy('id','asc')->get();
        $this->verListaBitacoraExitosa('TIPO-UBICACION',null,$request->header());
        return $this->successResponse($data,'lista de tipos de ubicacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoUbicacionRequest $request)
    {
        $validado = $request->validated();
        $nuevoTipo = Tipo_ubicacion::create($validado);
        $this->crearBitacoraExitosa('TIPO-UBICACION',null,$request->header());
        return $this->successResponse($nuevoTipo,'creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ubicacion\Tipo_ubicacion  $tipo_ubicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Tipo_ubicacion $tipo_ubicacion)
    {
        try{
            $this->verBitacoraExitosa('TIPO-UBICACION',$tipo_ubicacion->id,$request->header());
            return $this->successResponse($tipo_ubicacion);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubicacion\Tipo_ubicacion  $tipo_ubicacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoUbicacionRequest $request, Tipo_ubicacion $tipo_ubicacion)
    {
        try{
            $validado = $request->validated();
            
            $tipo_ubicacion->update($validado);
            $this->actualizarBitacoraExitosa('TIPO-UBICACION',$tipo_ubicacion->id,$request->header());
            return $this->successResponse($tipo_ubicacion,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubicacion\Tipo_ubicacion  $tipo_ubicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Tipo_ubicacion $tipo_ubicacion)
    {
        try{
            $c = $tipo_ubicacion->id;
            $tipo_ubicacion->delete();
            $this->eliminarBitacoraExitosa('TIPO-UBICACION',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
