<?php

namespace App\Utils;

class FileHandler
{

    public static function save($file, $path, $fileName = "")
    {
        if (empty($fileName)) {
            $fileName = sha1($file['name']);
            $ext = explode('.', $file['name'])[1];
            $fileName .= '.' . $ext;
        }
        $fileOldPath = $file['tmp_name'];
        $fullpath = "storage/" . $path . "/" . $fileName;
        move_uploaded_file($fileOldPath, dirname(__DIR__) . '/../public/' . $fullpath);
        return $fullpath;
    }
}
