<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuario\Permiso;
use App\Models\Usuario\Rol;
use App\Models\Usuario\Usuario;
use App\Traits\ApiResponse;
use App\Traits\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use Bitacora;
    use ApiResponse;
    public function login(LoginRequest $request){
        $validado = $request->validated();
        if (Auth::attempt($validado)) {
            $datos = Usuario::where('username',$validado['username'])->first();
            $rol = Rol::find($datos['rol_id']);
            $permisos = $rol->permisos;
            $datos['permisos'] = $permisos->pluck('id');
            $this->logBitacora('LOGIN','LOG-IN','EXITOSO',null,$request->header());
            return $this->successResponse($datos,'autorizado');
        }else{
            return $this->Unauthorized();
        }
        
    }

    public function logout(Request $request){
        $this->logBitacora('LOGOUT','LOG-OUT','EXITOSO',null,$request->header());
        return $this->successResponse(null,'session cerrada exitosamente');
    }
}
