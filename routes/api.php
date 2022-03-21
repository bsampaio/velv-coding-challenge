<?php

use App\Http\Controllers\ServersController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/servers/update-source', [ServersController::class, 'updateDataSource']);
Route::get('/servers', [ServersController::class, 'readDataSource']);
Route::get('/servers/locations', [ServersController::class, 'getLocations']);
