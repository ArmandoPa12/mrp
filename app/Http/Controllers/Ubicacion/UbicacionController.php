<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ubicacion\StoreUbicacionRequest;
use App\Http\Requests\Ubicacion\UpdateUbicacionRequest;
use App\Models\Ubicacion\Ubicacion;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ubicacion::with('tipoUbicacion')->get();
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

        return $this->successResponse($newUbicacion,'creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ubicacion\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Ubicacion $ubicacion)
    {
        try{
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
            if($ubicacion->cant_estantes > 0){
                return $this->Unauthorized();
            }
            $updated = $request->validated();
            $ubicacion->update($updated);
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
    public function destroy(Ubicacion $ubicacion)
    {
        try{
            if($ubicacion->cant_estantes > 0){
                return $this->Unauthorized();
            }
            $ubicacion->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
