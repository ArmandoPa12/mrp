<?php

use App\Http\Controllers\Articulo\ArticuloController;
use App\Http\Controllers\Articulo\TipoArticuloController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Proceso\ListaProcesoController;
use App\Http\Controllers\Proceso\ProcesoController;
use App\Http\Controllers\Produccion\EstadoProduccionController;
use App\Http\Controllers\Ubicacion\EstanteController;
use App\Http\Controllers\Ubicacion\TipoUbicacionController;
use App\Http\Controllers\Ubicacion\UbicacionArticuloController;
use App\Http\Controllers\Ubicacion\UbicacionController;
use App\Http\Controllers\Usuario\RolController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Models\Articulo\Articulo;
use App\Models\Articulo\Tipo_Articulo;
use App\Models\Proceso\Lista_Proceso;
use App\Models\Ubicacion\Estante;
use App\Models\Ubicacion\Tipo_Ubicacion;
use App\Models\Ubicacion\Ubicacion;
use App\Models\Ubicacion\Ubicacion_Articulo;
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
Route::apiResource('/estante',EstanteController::class)->parameter('estantes','estante');
Route::apiResource('/tipo-articulo',TipoArticuloController::class)->parameter('tarticulos','tarticulo');
Route::apiResource('/articulo',ArticuloController::class)->parameter('articulos','articulo');
Route::apiResource('/ubicacion-articulo',UbicacionArticuloController::class)->parameter('uarticulos','uarticulo');
Route::apiResource('/proceso',ProcesoController::class)->parameter('procesos','proceso');
Route::apiResource('/lista-proceso',ListaProcesoController::class)->parameter('lprocesos','lproceso');
Route::apiResource('/estado-produccion',EstadoProduccionController::class)->parameter('tproducciones','tproduccion');





Route::post('/login',[AuthController::class,'login']);


Route::get('/test',function(){
    $data = Ubicacion_Articulo::with(['estante','articulo'])->get();
    return $data;
});
