<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Ubicacion_Articulo;
use App\Http\Requests\Ubicacion\StoreUbicacion_ArticuloRequest;
use App\Http\Requests\Ubicacion\UpdateUbicacion_ArticuloRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class UbicacionArticuloController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ubicacion_Articulo::with(['estante.ubicacion','articulo'])->get();
        return $this->successResponse($data,'lista');
    }

    public function store(StoreUbicacion_ArticuloRequest $request)
    {
        $validado = $request->validated();
        $nuevo = Ubicacion_Articulo::create($validado);
        return $this->successResponse($nuevo);
    }

    public function update(Request $request, $id)
    {
        try{
            $actualizado = Ubicacion_Articulo::findOrFail($id);
            // $actualizado->update($request->all());
            return $this->successResponse($actualizado ,'actualiado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ubicacion\Ubicacion_Articulo  $ubicacion_Articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        try{
            $ubicacion_Articulo = Ubicacion_Articulo::findOrFail($id);
            $ubicacion_Articulo->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
