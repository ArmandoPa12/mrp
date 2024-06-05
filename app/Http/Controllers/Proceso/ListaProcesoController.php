<?php

namespace App\Http\Controllers\Proceso;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proceso\StoreListProcessRequest;
use App\Http\Requests\Proceso\UpdateListProcessRequest;
use App\Models\Proceso\Lista_Proceso;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ListaProcesoController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lista_Proceso::with(['proceso','producto'])->get();
        return $this->successResponse($data,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListProcessRequest $request)
    {
        $validado = $request->validated();
        $listaProceso = Lista_Proceso::create($validado);
        return $this->successResponse($listaProceso,'proceso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceso\Lista_Proceso  $lista_Proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Lista_Proceso $lista_Proceso)
    {
        try{
            
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
    public function destroy(Lista_Proceso $lista_Proceso)
    {
        try{
            $lista_Proceso->delete();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }
}
