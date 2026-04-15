<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\fileController;
use App\Http\Controllers\folderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('files',[fileController::class,'store']);
Route::post('/files/{id}/copy', [fileController::class, 'copy']);
Route::post('/files/{id}/move', [fileController::class, 'move']);
Route::post('/files/{id}/rename', [fileController::class, 'rename']);
Route::delete('/files/{id}', [fileController::class, 'destroy']);
Route::get('/files/{id}/download', [fileController::class, 'download']);

Route::post('folders',[folderController::class,'store']);
// folder/{id}/file/{UUid}





