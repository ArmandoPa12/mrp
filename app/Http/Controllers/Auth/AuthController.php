<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuario\Usuario;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(LoginRequest $request){
        $validado = $request->validated();
        if (Auth::attempt($validado)) {
            $datos = Usuario::where('username',$validado['username'])->first();
            return $this->successResponse($datos,'autorizado');
        }else{
            return $this->Unauthorized();
        }
        
    }
}
