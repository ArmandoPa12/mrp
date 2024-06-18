<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rol\StoreRolRequest;
use App\Http\Requests\Rol\UpdateRolRequest;
use App\Models\Usuario\Rol;
use App\Traits\Bitacora;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class RolController extends Controller
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
        $roles = Rol::orderBy('id','asc')->with('permisos')->get();
        $this->verListaBitacoraExitosa('ROL',null,$request->header());
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
            'funcion' => $validatedData['funcion'],
            'responsabilidad' => $validatedData['responsabilidad'],
        ]);
        $newRol->permisos()->attach($validatedData['permisos']);
        $this->crearBitacoraExitosa('ROL',$newRol->id,$request->header());
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
                'funcion' => $data['funcion'],
                'responsabilidad' => $data['responsabilidad'],
            ]);
            $rol->permisos()->sync($data['permisos']);
            $this->actualizarBitacoraExitosa('ROL',$rol->id,$request->header());
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
            $this->eliminarBitacoraExitosa('ROL',$rol->id,$request->header());
            return $this->successResponse(null,'Rol eliminado');
        }catch(\Exception $e){
            // return $this->successResponse(null,'error',404);
            return $this->notFoundResponse();
        }
        
    }
}
