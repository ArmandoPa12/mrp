<?php

namespace App\Http\Controllers\Articulo;

use App\Http\Controllers\Controller;
use App\Models\Articulo\Tipo_articulo;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TipoArticuloController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dato = Tipo_articulo::all();
        return $this->successResponse($dato,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = Tipo_articulo::create([
            'nombre' => $request['nombre']
        ]);

        return $this->successResponse($nuevo,'creado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articulo\Tipo_articulo  $tipo_articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipo_articulo $tipo_articulo)
    {
        try{
            $tipo_articulo->nombre = $request['nombre'];
            return $this->successResponse($tipo_articulo,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articulo\Tipo_articulo  $tipo_articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo_articulo $tipo_articulo)
    {
        try{
            $tipo_articulo->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
