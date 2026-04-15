<?php

namespace App\Http\Controllers;

use app\Services\folderService;
use Illuminate\Http\Request;

class folderController extends Controller
{
    public function __construct(protected folderService $fs){}
    public function store(Request $request){

        
        $this->fs->createFolder(
            $request->name,
            $request->parent_id,
        );
        return "accepted";
    }
}