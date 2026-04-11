<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

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
}
