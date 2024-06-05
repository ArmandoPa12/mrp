<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Ubicacion_Articulo;
use App\Http\Requests\StoreUbicacion_ArticuloRequest;
use App\Http\Requests\UpdateUbicacion_ArticuloRequest;

class UbicacionArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUbicacion_ArticuloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUbicacion_ArticuloRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ubicacion\Ubicacion_Articulo  $ubicacion_Articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Ubicacion_Articulo $ubicacion_Articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUbicacion_ArticuloRequest  $request
     * @param  \App\Models\Ubicacion\Ubicacion_Articulo  $ubicacion_Articulo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUbicacion_ArticuloRequest $request, Ubicacion_Articulo $ubicacion_Articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubicacion\Ubicacion_Articulo  $ubicacion_Articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ubicacion_Articulo $ubicacion_Articulo)
    {
        //
    }
}
