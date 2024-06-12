<?php

namespace App\Http\Controllers\Articulo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Articulo\StoreArticuloRequest;
use App\Http\Requests\Articulo\UpdateArticuloRequest;
use App\Models\Articulo\Articulo;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{   use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Articulo::orderBy('id','asc')->with(['tipo', 'materiales'])->get();
        return $this->successResponse($data,'lista');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticuloRequest $request)
    {   
        $validado = $request->validated();
        try{
            DB::beginTransaction();
            $articulo = Articulo::create([
                'nombre' => $validado['nombre'],
                'descripcion' => $validado['descripcion'],
                'fecha_creacion' => $validado['fecha_creacion'],
                'fecha_vencimiento' => $validado['fecha_vencimiento'],
                'cantidad' => 0,
                'imagen' => $validado['imagen'],
                'serie' => $validado['serie'],
                'tipo_id' => $validado['tipo_id'],
            ]);
            if($validado['tipo_id'] == 2){
                $materialesData = [];
                foreach ($validado['materiales'] as $material) {
                    $materialesData[$material['id']] = ['cantidad' => $material['cantidad']];
                }
                $articulo->materiales()->sync($materialesData);
            }
            DB::commit();
            return $this->successResponse($articulo);
        }catch(\Exception $e){
            // DB::rollBack();
            return $this->successResponse(null);

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articulo\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        try{
            return $this->successResponse($articulo);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articulo\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticuloRequest $request, Articulo $articulo)
    {
        $validado = $request->validated();
        try{
            $articulo->update([
                'nombre' => $validado['nombre'],
                'descripcion' => $validado['descripcion'],
                'fecha_creacion' => $validado['fecha_creacion'],
                'fecha_vencimiento' => $validado['fecha_vencimiento'],
                'imagen' => $validado['imagen'],
            ]);
            if($validado['tipo_id'] == 2){
                $materialesData = [];
                foreach ($validado['materiales'] as $material) {
                    $materialesData[$material['id']] = ['cantidad' => $material['cantidad']];
                }
                $articulo->materiales()->sync($materialesData);
            }
            DB::commit();
            return $this->successResponse($articulo);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articulo\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        try{
            if($articulo->cantidad>0){
                return $this->Unauthorized();
            }
            DB::beginTransaction();
            $articulo->materiales()->delete();
            $articulo->delete();
            DB::commit();
            return $this->successResponse(null,'eliminado');
        }catch(\Exception $e){
            DB::rollBack();
            return $this->notFoundResponse();
        }
    }
}
