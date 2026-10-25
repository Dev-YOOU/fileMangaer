<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\File;
use App\models\Folder;
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
    public function copyFolder(int $folderId, ?int $targetParentId = null)
{
    return DB::transaction(function () use ($folderId, $targetParentId) {

        $folder = Folder::with([
            'files',
            'children.files',
            'children.children' // eager load deeper if needed
        ])->findOrFail($folderId);

        if ($targetParentId && $this->isDescendant($folderId, $targetParentId)) {
            throw new \Exception('Cannot copy folder into itself');
        }

        return $this->recursiveCopyFolder($folder, $targetParentId);
    });
}
private function recursiveCopyFolder(Folder $folder, ?int $parentId)
{
    //  Create new folder
    $newFolder = $this->folderService->createFolder(
        $this->generateCopyName($folder->name, $parentId),
        $parentId
    );

    //  Copy files (metadata only)
    foreach ($folder->files as $file) {
        $this->fileService->createFileRecord(
            $file->name,
            $file->storage_id, // 🔥 SAME storage
            $newFolder->id
        );
    }

    //  Copy child folders recursively
    foreach ($folder->children as $child) {
        $this->recursiveCopyFolder($child, $newFolder->id);
    }

    return $newFolder;
}
private function isDescendant(int $folderId, int $targetId): bool
{
    while ($targetId) {
        if ($targetId == $folderId) return true;

        $target = Folder::find($targetId);
        $targetId = $target?->parent_id;
    }

    return false;
}
private function generateCopyName(string $name, ?int $parentId): string
{
    $baseName = $name . ' (copy)';
    $newName = $baseName;
    $counter = 2;

    while (
        Folder::where('parent_id', $parentId)
            ->where('name', $newName)
            ->exists()
    ) {
        $newName = $name . " (copy {$counter})";
        $counter++;
    }

    return $newName;
}
}
