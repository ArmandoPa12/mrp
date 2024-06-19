<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ubicacion\StoreUbicacionRequest;
use App\Http\Requests\Ubicacion\UpdateUbicacionRequest;
use App\Models\Ubicacion\Ubicacion;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class UbicacionController extends Controller
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
        $data = Ubicacion::with('tipoUbicacion')->get();
        $this->verListaBitacoraExitosa('UBICACION',null,$request->header());
        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUbicacionRequest $request)
    {
        $validado = $request->validated();
        $newUbicacion = Ubicacion::create([
            'tipo_id' => $validado['tipo_id'],
            'direccion' => $validado['direccion'],
            'cant_estantes' => 0
        ]);
        $this->crearBitacoraExitosa('UBICACION',$newUbicacion->id,$request->header());
        return $this->successResponse($newUbicacion,'creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ubicacion\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Ubicacion $ubicacion)
    {
        try{
            $this->verBitacoraExitosa('UBICACION',$ubicacion->id,$request->header());
            return $this->successResponse($ubicacion);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubicacion\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUbicacionRequest $request, Ubicacion $ubicacion)
    {
        try{
            $c=$ubicacion->id;
            // if($ubicacion->cant_estantes > 0){
            //     $this->logBitacora('ELIMINAR','UBICACION','FALLIDO',$c,$request->header());
            //     return $this->Unauthorized();
            // }
            $updated = $request->validated();
            $ubicacion->update($updated);
            $this->eliminarBitacoraExitosa('UBICACION',$c,$request->header());
            return $this->successResponse($ubicacion,'actualizado');
            
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubicacion\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ubicacion $ubicacion)
    {
        try{
            // if($ubicacion->cant_estantes > 0){
            //     return $this->Unauthorized();
            // }
            $ubicacion->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
