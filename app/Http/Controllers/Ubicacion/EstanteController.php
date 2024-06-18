<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Estante;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class EstanteController extends Controller
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
        $data = Estante::with('ubicacion')->get();
        $this->verListaBitacoraExitosa('ESTANTE',null,$request->header());
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
        $this->crearBitacoraExitosa('ESTANTE',$nuevo->id,$request->header());
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
            $this->actualizarBitacoraExitosa('ESTANTE',$estante->id,$request->header());
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
    public function destroy(Request $request,Estante $estante)
    {
        try{
            $c = $estante->id;
            $estante->delete();
            $this->eliminarBitacoraExitosa('ESTANTE',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
