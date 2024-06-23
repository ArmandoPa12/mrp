<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Produccion\Orden_Produccion;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdeProduccionController extends Controller
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
        $data = Orden_Produccion::with(['usuarioGenerado','usuarioTrabajador','estadoProduccion'])->get();
        $this->verListaBitacoraExitosa('ORDEN-PRODUCCION',null,$request->header());
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
        $file = $request->file('pdf_data');
        $fileName = time() . '_' . $file->getClientOriginalName();
        

        $filePath = Storage::disk('public')->put('pdfs/produccion', $file);

        $fileUrl = Storage::disk('public')->url($filePath);

        $nuevo = Orden_Produccion::create([
            'usuario_id_ge' => $request->input('usuario_id_ge'),
            'usuario_id_tr' => $request->input('usuario_id_tr'),
            'estado_produccion_id' => $request->input('estado_produccion_id'),
            'fechar_hora' => $request->input('fecha_hora'),
            'pdf_data' => $fileUrl, // Guardar la ruta del archivo
            'file_name' => $fileName,
            'mime_type' => $file->getClientMimeType(),
        ]);

        // $nuevo = Orden_Produccion::create($request->all());
        $this->crearBitacoraExitosa('ORDEN-PRODUCCION',$nuevo->id,$request->header());
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
            $this->actualizarBitacoraExitosa('ORDEN-PRODUCCION',$id,$request->header());
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
    public function destroy(Request $request,$id)
    {
        try{
            $orden_Produccion = Orden_Produccion::findOrFail($id);
            $orden_Produccion->delete();
            $this->eliminarBitacoraExitosa('ORDEN-PRODUCCION',$id,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
