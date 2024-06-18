<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Estado_Orden_Compra;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class EstadoOrdenCompraController extends Controller
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
        $datos = Estado_Orden_Compra::all();
        $this->verListaBitacoraExitosa('ESTADO-ORDEN-COMPRA',null,$request->header());
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
        $nuevo = Estado_Orden_Compra::create($request->all());
        $this->crearBitacoraExitosa('ESTADO-ORDEN-COMPRA',$nuevo->id,$request->header());
        return $this->successResponse($nuevo,'creado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra\Estado_Orden_Compra  $estado_Orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $estado_Orden_Compra = Estado_Orden_Compra::findOrFail($id);
            $estado_Orden_Compra->update([
                'descripcion' => $request->descripcion
            ]);
            $this->actualizarBitacoraExitosa('ESTADO-ORDEN-COMPRA',$id,$request->header());
            return $this->successResponse($estado_Orden_Compra,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra\Estado_Orden_Compra  $estado_Orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            $estado_Orden_Compra = Estado_Orden_Compra::findOrFail($id);
            $estado_Orden_Compra->delete();
            $this->eliminarBitacoraExitosa('ESTADO-ORDEN-COMPRA',$id,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
