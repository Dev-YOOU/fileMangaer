<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\fileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('files',[fileController::class,'store']);
Route::post('/files/{id}/copy', [FileController::class, 'copy']);
Route::post('/files/{id}/move', [FileController::class, 'move']);


// folder/{id}/file/{UUid}





