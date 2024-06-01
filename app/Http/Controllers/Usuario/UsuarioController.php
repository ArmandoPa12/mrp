<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Models\Usuario\Persona;
use App\Models\Usuario\Usuario;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Usuario::with('rol','persona')->get();
        return $this->successResponse($data,'lista usuarios');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsuarioRequest $request)
    {
        $validado = $request->validated();
        $persona = Persona::create([
            'nombre' => $validado['nombre'],
            'apellido_p' => $validado['apellido_p'],
            'apellido_m' => $validado['apellido_m'],
            'nacimiento' => $validado['nacimiento'],
            'ci' => $validado['ci']
        ]);
        $usuario = Usuario::create([
            'rol_id' => $validado['rol_id'],
            'persona_id' => $persona->id,
            'photo' => $validado['photo']?? null,
            'correo' => $validado['correo'],
            'username' => $validado['username'],
            'password' => Hash::make($validado['password']),
        ]);

        return $this->successResponse($usuario,'usuario creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        try{
            return $this->successResponse($usuario);
        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        try{
        $validado = $request->validated();
        $usuario->persona()->update([
            'nombre' => $validado['nombre'],
            'apellido_p' => $validado['apellido_p'],
            'apellido_m' => $validado['apellido_m'],
            'nacimiento' => $validado['nacimiento'],
            'ci' => $validado['ci']
        ]);
        $usuario->update([
            'rol_id' => $validado['rol_id'],
            'photo' => $validado['photo']?? null,
            'correo' => $validado['correo'],
            'username' => $validado['username'],
        ]);

        return $this->successResponse($usuario,'usuario actualizado');

        }catch(\Exception $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        try{
            DB::beginTransaction();
            $usuario->persona()->delete();
            $usuario->delete();
            DB::commit();

            return $this->successResponse(null,'usuario eliminado');
        }catch(\Exception $e){
            DB::rollBack();
            return $this->notFoundResponse();
        }
    }
}
