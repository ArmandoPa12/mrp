<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Ubicacion\TipoUbicacionController;
use App\Http\Controllers\Ubicacion\UbicacionController;
use App\Http\Controllers\Usuario\RolController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Models\Ubicacion\Estante;
use App\Models\Ubicacion\Tipo_Ubicacion;
use App\Models\Ubicacion\Ubicacion;
use App\Models\Usuario\Rol;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/rol',RolController::class)->parameter('roles','rol');
Route::apiResource('/usuario',UsuarioController::class)->parameter('usuarios','usuario');
Route::apiResource('/tipo-ubicacion',TipoUbicacionController::class)->parameter('tubicaciones','tubicacion');
Route::apiResource('/ubicacion',UbicacionController::class)->parameter('ubicaciones','ubicacion');
Route::post('/login',[AuthController::class,'login']);


Route::get('/test',function(){
    $data = Estante::with('ubicacion')->get();
    return $data;
});
