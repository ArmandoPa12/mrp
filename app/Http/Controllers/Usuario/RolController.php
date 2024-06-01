<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rol\StoreRolRequest;
use App\Http\Requests\Rol\UpdateRolRequest;
use App\Models\Usuario\Rol;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class RolController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::orderBy('id','asc')->with('permisos')->get();
        return $this->successResponse($roles,'roles');
        // return response()->json([$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolRequest $request)
    {
        $validatedData = $request->validated();
        $newRol = Rol::create([
            'nombre' => $validatedData['nombre'],
            'descripcion' => $validatedData['descripcion'],
        ]);
        $newRol->permisos()->attach($validatedData['permisos']);
        return $this->successResponse($newRol,'rol creado');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolRequest $request, Rol $rol)
    {   
        try {
            $data = $request->validated();
            $rol->update([
                'nombre'=> $data['nombre'],
                'descripcion'=>$data['descripcion']
            ]);
            $rol->permisos()->sync($data['permisos']);
            return $this->successResponse($rol, 'Rol actualizado');
        }catch (\Exception $e){
            // return $this->successResponse(null,$e,404);
            return $this->notFoundResponse();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rol $rol)
    {
        try{
            $rol->delete();
            return $this->successResponse(null,'Rol eliminado');
        }catch(\Exception $e){
            // return $this->successResponse(null,'error',404);
            return $this->notFoundResponse();
        }
        
    }
}
