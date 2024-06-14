<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Orden_Compra;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = Orden_Compra::with(['usuarioGenerado','usuarioGestor','proveedor','estadoCompra'])->get();
        return $this->successResponse($datos); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = Orden_Compra::create($request->all());
        return $this->successResponse($datos,'creaado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra\Orden_Compra  $orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden_Compra $orden_Compra)
    {
        try{
            $orden_Compra->update($request->all());
            return $this->successResponse($orden_Compra,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra\Orden_Compra  $orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orden_Compra $orden_Compra)
    {
        try{
            $orden_Compra->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
