<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Orden_Compra;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdenCompraController extends Controller
{
    use ApiResponse;
    use Bitacora;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datos = Orden_Compra::with(['usuarioGenerado','usuarioGestor','proveedor','estadoCompra'])->get();
        $this->verListaBitacoraExitosa('ORDEN-COMPRA',null,$request->header());
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
        $file = $request->file('pdf_data');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = Storage::disk('public')->put('pdfs/compra', $file);
        $fileUrl = Storage::disk('public')->url($filePath);
        $datos = Orden_Compra::create([
            'usuario_id_gen' => $request->input('usuario_id_ge'),
            'usuario_id_ges' => $request->input('usuario_id_ges'),
            'estado_compra_id' => $request->input('estado_compra_id'),
            'proveedor_id' => $request->input('proveedor_id'),
            'fecha_hora' => $request->input('fecha_hora'),
            'pdf_data' => $fileUrl, // Guardar la ruta del archivo
            'file_name' => $fileName,
            'mime_type' => $file->getClientMimeType(),
        ]);
        // $datos = Orden_Compra::create($request->all());
        $this->crearBitacoraExitosa('ORDEN-COMPRA',$datos->id,$request->header());
        return $this->successResponse($datos,'creaado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra\Orden_Compra  $orden_Compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $orden_Compra = Orden_Compra::findOrFail($id);
            $orden_Compra->update($request->all());
            $this->actualizarBitacoraExitosa('ORDEN-COMPRA',$id,$request->header());
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
    public function destroy(Request $request,$id)
    {
        try{
            $orden_Compra = Orden_Compra::findOrFail($id);
            $orden_Compra->delete();
            $this->eliminarBitacoraExitosa('ORDEN-COMPRA',$id,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
