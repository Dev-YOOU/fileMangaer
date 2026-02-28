<?php

namespace App\Http\Controllers;

use App\Models\file;
use Illuminate\Http\Request;

class fileController extends Controller
{
    public function upload(Request $request){
        // recive file and it's properties and the user upaloded it and the folder it's included 
        file::create();
        return response()->json([
            'message'=>"couldn't upload file",
        ]);
    }
    public function download(Request $request){
        return response()->json([
            "message"=>"couldn't download file"
        ]);
    }
    public function show(Request $request){
        return response()->json([
            "message"=>"couldn't download file"
        ]);
    }
    public function destroy(Request $request){
        return response()->json([
            "message"=>"couldn't download file"
        ]); 
    }
    public function move(Request $request){
        return response()->json([
            "message"=>"couldn't download file"
        ]);
    }
    public function copy(Request $request){
        return response()->json([
            "message"=>"couldn't download file"
        ]);
    }
}
