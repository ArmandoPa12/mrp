<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Proveedor;
use App\Models\Compra\Proveedor_Materiales;
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
        $data = Proveedor::with('lista_materiales.material')->get();
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
            'lista_materiales' => 'required|array',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'celular' => 'required',
            'empresa' => 'required|string|max:255',
        ]);

        $nuevo = Proveedor::create([
            'articulo_id' => 1,
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'celular' => $validated['celular'],
            'empresa' => $validated['empresa'],
        ]);

        $createdProveedores = [];
        foreach ($validated['lista_materiales'] as $articulo_id) {

            $creado = Proveedor_Materiales::create([
                'proveedor_id' => $nuevo->id,
                'material_id' => $articulo_id
            ]);
            $createdProveedores[] = $creado;
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
            Proveedor_Materiales::where('proveedor_id', $proveedor->id)->delete();
            // $proveedor->update($request->all());
            $proveedor->update([
                'nombre' => $request['nombre'],
                'apellido' => $request['apellido'],
                'celular' => $request['celular'],
                'empresa' => $request['empresa'],
            ]);

            $createdProveedores = [];
            foreach ($request['lista_materiales'] as $articulo_id) {

                $creado = Proveedor_Materiales::create([
                    'proveedor_id' => $proveedor->id,
                    'material_id' => $articulo_id
                ]);
                $createdProveedores[] = $creado;
            }


            $this->actualizarBitacoraExitosa('PROVEEDOR',$proveedor->id,$request->header());
            return $this->successResponse($createdProveedores,'actualizado');
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
            Proveedor_Materiales::where('proveedor_id', $proveedor->id)->delete();
            $proveedor->delete();
            $this->eliminarBitacoraExitosa('PROVEEDOR',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
