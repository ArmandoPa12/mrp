<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\Orden_Produccion;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrdeProduccionController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Orden_Produccion::with(['usuarioGenerado','usuarioTrabajador','estadoProduccion'])->get();
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
        $nuevo = Orden_Produccion::create($request->all());
        return $this->successResponse($nuevo,'creado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produccion\Orden_Produccion  $orden_Produccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $orden_Produccion = Orden_Produccion::findOrFail($id);
            $orden_Produccion->update($request->all());
            return $this->successResponse($orden_Produccion,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produccion\Orden_Produccion  $orden_Produccion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $orden_Produccion = Orden_Produccion::findOrFail($id);
            $orden_Produccion->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
