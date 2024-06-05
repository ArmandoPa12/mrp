<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Estante;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EstanteController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Estante::with('ubicacion')->get();
        return $this->successResponse($data,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = Estante::create([
            'ubicacion_id' => $request['ubicacion_id'],
            'cant_fila' => $request['cant_fila']
        ]);
        return $this->successResponse($nuevo,'creado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ubicacion\Estante  $estante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estante $estante)
    {   
        try{
            $estante->update([
                'ubicacion_id' => $request['ubicacion_id'],
                'cant_fila' => $request['cant_fila']
            ]);

            return $this->successResponse($estante,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubicacion\Estante  $estante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estante $estante)
    {
        try{
            $estante->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
