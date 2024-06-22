<?php

namespace App\Http\Controllers\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Ubicacion_Articulo;
use App\Http\Requests\Ubicacion\StoreUbicacion_ArticuloRequest;
use App\Http\Requests\Ubicacion\UpdateUbicacion_ArticuloRequest;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;
class UbicacionArticuloController extends Controller
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
        $data = Ubicacion_Articulo::with(['estante.ubicacion','articulo.materiales', 'articulo.tipo'])->get();
        $this->verListaBitacoraExitosa('UBICACION-ARTICULO',null,$request->header());
        return $this->successResponse($data,'lista');
    }

    public function store(StoreUbicacion_ArticuloRequest $request)
    {
        $validado = $request->validated();
        $nuevo = Ubicacion_Articulo::create($validado);
        $this->crearBitacoraExitosa('UBICACION-ARTICULO',$nuevo->id,$request->header());
        return $this->successResponse($nuevo);
    }

    public function update(Request $request, $id)
    {
        try{
            $actualizado = Ubicacion_Articulo::findOrFail($id);
            // $actualizado->update($request->all());
            $this->actualizarBitacoraExitosa('UBICACION-ARTICULO',$id,$request->header());
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
    public function destroy(Request $request, Request $id)
    {
        try{
            $ubicacion_Articulo = Ubicacion_Articulo::findOrFail($id);
            $ubicacion_Articulo->delete();
            $this->eliminarBitacoraExitosa('UBICACION-ARTICULO',$id,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
