<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\Estado_Produccion;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class EstadoProduccionController extends Controller
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
        $datos = Estado_Produccion::all();
        $this->verListaBitacoraExitosa('ESTADO-PRODUCCION',null,$request->header());
        return $this->successResponse($datos,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = Estado_Produccion::create([
            'descripcion' => $request['descripcion']
        ]);
        $this->crearBitacoraExitosa('ESTADO-PRODUCCION',$nuevo->id,$request->header());
        return $this->successResponse($nuevo,'creado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\Estado_Produccion  $estado_Produccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $actual = Estado_Produccion::findOrFail($id);
            $actual->update([
                'descripcion' => $request['descripcion']
            ]);
            $this->actualizarBitacoraExitosa('ESTADO-PRODUCCION',$id,$request->header());
            return $this->successResponse($actual,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\Estado_Produccion  $estado_Produccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try{
            $actual = Estado_Produccion::findOrFail($id);
            $actual->delete();
            $this->eliminarBitacoraExitosa('ESTADO-PRODUCCION',$id,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
