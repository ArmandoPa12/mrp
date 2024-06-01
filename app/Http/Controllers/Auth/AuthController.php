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
            $data = Usuario::where('username',$validado['username'])->get();
            return $this->successResponse($data,'entro');
        }else{
            return $this->Unauthorized();
        }
    }
}
