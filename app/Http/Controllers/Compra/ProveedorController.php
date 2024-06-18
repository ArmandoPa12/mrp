<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Proveedor;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class ProveedorController extends Controller
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
        $data = Proveedor::all();
        $this->verListaBitacoraExitosa('PROVEEDOR',null,$request->header());
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

        // $nuevo = Proveedor::create($request->all());
        $validated = $request->validate([
            'articulos_id' => 'required|array',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'celular' => 'required',
            'empresa' => 'required|string|max:255',
        ]);
        $createdProveedores = [];
        foreach ($validated['articulos_id'] as $articulo_id) {
            $proveedor = Proveedor::create([
                'articulo_id' => $articulo_id,
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'celular' => $validated['celular'],
                'empresa' => $validated['empresa'],
            ]);

            $createdProveedores[] = $proveedor;
        }

        $this->crearBitacoraExitosa('PROVEEDOR',null,$request->header());
        return $this->successResponse($createdProveedores,'creado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        try{
            $proveedor->update($request->all());
            $this->actualizarBitacoraExitosa('PROVEEDOR',$proveedor->id,$request->header());
            return $this->successResponse($proveedor,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Proveedor $proveedor)
    {
        try{
            $c = $proveedor->id;
            $proveedor->delete();
            $this->eliminarBitacoraExitosa('PROVEEDOR',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
