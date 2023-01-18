<?php

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
/*Route::get('/series',function(){
    return \App\Models\Serie::all();
});*/
//Route::resource();
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/series', \App\Http\Controllers\Api\SerieController::class);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email','password']);
    $user = \App\Models\User::whereEmail($credentials['email'])->first();
    if(Auth::attempt($credentials)===false){
        return response()->json('Unauthorized',401);
    }
    $user = Auth::User();
    $user->tokens()->delete();
    $token = $user->createToken('token',['is_admin']);
    return response()->json($token->plainTextToken);
});