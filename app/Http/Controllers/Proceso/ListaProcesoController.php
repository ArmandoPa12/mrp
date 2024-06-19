<?php

namespace App\Http\Controllers\Proceso;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proceso\StoreListProcessRequest;
use App\Http\Requests\Proceso\UpdateListProcessRequest;
use App\Models\Proceso\Lista_Proceso;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;

class ListaProcesoController extends Controller
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
        $data = Lista_Proceso::with(['proceso','producto'])->get();
        $this->verBitacoraExitosa('LISTA-PROCESO',null,$request->header());
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
        $validado = $request->validate([
            'producto_id' => 'required|integer',
            'proceso' => 'required|array',
            'proceso.*.id' => 'required|integer',
            'proceso.*.paso' => 'required|integer',
            'proceso.*.tiempo' => 'required|date_format:H:i:s',
        ]);

        $procesosData = [];
        foreach ($validado['proceso'] as $proceso) {
            $procesosData[] = [
                'producto_id' => $validado['producto_id'],
                'proceso_id' => $proceso['id'],
                'paso' => $proceso['paso'],
                'tiempo' => $proceso['tiempo'],
            ];
        }
        // $validado = $request->validated();
        // $listaProceso = Lista_Proceso::create($validado);
        $listaProceso = Lista_Proceso::insert($procesosData);
        foreach ($procesosData as $procesoData) {
            $this->crearBitacoraExitosa('LISTA-PROCESO', $procesoData['producto_id'], $request->header());
        }
        return $this->successResponse($listaProceso,'proceso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceso\Lista_Proceso  $lista_Proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Lista_Proceso $lista_Proceso)
    {
        try{
            $this->verBitacoraExitosa('LISTA-PROCESO',$lista_Proceso->id,$request->header());
            return $this->successResponse($lista_Proceso);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proceso\Lista_Proceso  $lista_Proceso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListProcessRequest $request, Lista_Proceso $lista_Proceso)
    {   
        try{
            $validado = $request->validated();
            $lista_Proceso->update($validado);
            $this->actualizarBitacoraExitosa('LISTA-PROCESO',$lista_Proceso->id,$request->header());
            return $this->successResponse($lista_Proceso,'actualizado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proceso\Lista_Proceso  $lista_Proceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Lista_Proceso $lista_Proceso)
    {
        try{
            $c = $lista_Proceso->id;
            $lista_Proceso->delete();
            $this->eliminarBitacoraExitosa('LISTA-PROCESO',$c,$request->header());
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
