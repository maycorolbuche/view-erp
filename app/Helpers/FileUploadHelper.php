<?php

namespace App\Helpers;

use App\Models\File;

class FileUploadHelper
{
    public static function upload($file, $type = "")
    {
        if (!$file) {
            return null;
        }

        $path = $file->store($type, 'public');
        $storedName = basename($path);

        $data = [
            'original_name' => $file->getClientOriginalName(),
            'stored_name'   => $storedName,
            'extension'     => $file->getClientOriginalExtension(),
            'mime_type'     => $file->getClientMimeType(),
            'size'          => $file->getSize(),
            'type'          => $type,
            'path'          => $path,
            'disk'          => 'public',
            'hash'          => sha1_file($file->getRealPath()),
        ];

        $file = File::create($data);

        return  $file;
    }
}
