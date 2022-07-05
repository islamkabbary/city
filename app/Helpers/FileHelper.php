<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function upload_file($folder_path, $uploaded_file)
    {
        $url = $uploaded_file->store($folder_path);
        return $url;
    }

    public static function update_file($folder_path, $image , $old_image)
    {
        if(Storage::exists($old_image)) {
            Storage::delete($old_image);
        }
        $url = $image->store($folder_path);
        return $url;
    }

    public static function delete_picture($picture)
    {
        Storage::delete($picture);
        return true;
    }
}
