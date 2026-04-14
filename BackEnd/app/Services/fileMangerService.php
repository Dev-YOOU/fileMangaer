<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class fileMangerService
{

    public function __construct(
        protected fileService $fileService,
        protected folderService $folderService
    ) {}

    public function uploadFile(
        $file,
        ?int $folderId = null,
    ) {
        return DB::transaction(function () use ($file, $folderId, ) {

            $storage = $this->fileService->storePhysicalFile($file);

            return $this->fileService->createFileRecord(
                $file->getClientOriginalName(),
                $storage->id,
                $folderId,
            );
        });
    }
    public function copyFile(
        int $fileId,
        ?int $targetFolderId = null)
    {
        return DB::transaction(function () use ($fileId, $targetFolderId) {

            $file = File::findOrFail($fileId);

            return $this->fileService->createFileRecord(
                $file->name . ' (copy)',
                $file->storage_id, // SAME storage!
                $targetFolderId
            );
        });
    }
    public function moveFile(
        int $fileId, 
        ?int $targetFolderId=null)
    {
    $file = File::findOrFail($fileId);

    $file->update([
        'folder_id' => $targetFolderId
    ]);

    return $file;
    }
    public function renameFile(
        int $fileId, 
        ?string $new_name
    ) {
        $file = File::findOrFail($fileId);

        $file->update([
        'name' => $new_name
    ]);
    return $file;
    }

        public function deleteFile(int $fileId)
    {
        $file = File::findOrFail($fileId);

        $this->fileService->deleteFile($file);
    }
      public function downloadFile(int $fileId){
        $file = File::with('storage')->findOrFail($fileId);
        $path = $file->storage->path;
        
        if (!Storage::exists($path)) {
        abort(404, 'File not found on disk');
    }

    return Storage::download($path, $file->name);
    }
}
