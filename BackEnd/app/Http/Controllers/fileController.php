<?php

namespace App\Http\Controllers;

use App\Services\fileMangerService;
use Illuminate\Http\Request;

class fileController extends Controller
{
    public function __construct(protected fileMangerService $fm) {}

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'folder_id' => 'nullable|exists:folders,id'
        ]);

        return $this->fm->uploadFile(
            $request->file('file'),
            $request->folder_id,
        );
    }

    public function copy($id, Request $request)
    {
        return $this->fm->copyFile($id, $request->target_folder_id);
    }
     public function move($id, Request $request)
    {
        return $this->fm->moveFile($id, $request->target_folder_id);
    }
    public function rename($id, Request $request){
        return $this->fm->renameFile($id,$request->new_name);
    }
     public function destroy($id)
    {
        $this->fm->deleteFile($id);

        return response()->json(['message' => 'deleted']);
    }

}
