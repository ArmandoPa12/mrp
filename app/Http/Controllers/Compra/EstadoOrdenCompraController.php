<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Estado_Orden_Compra;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EstadoOrdenCompraController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = Estado_Orden_Compra::all();
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
        return $this->successResponse($nuevo,'creado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra\Estado_Orden_Compra  $estado_Orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estado_Orden_Compra $estado_Orden_Compra)
    {
        try{
            $estado_Orden_Compra->update($request->all());
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
    public function destroy(Estado_Orden_Compra $estado_Orden_Compra)
    {
        try{
            $estado_Orden_Compra->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
