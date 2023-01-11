<?php

namespace App\Classes;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Upload
{
    /**
     * @var string
     */
    static string $disk = 'uploads';

    /**
     * @param UploadedFile $file
     * @param $path
     * @return string|false
     */
    static function file(UploadedFile $file, $path , ?string $prefix = null) :string |false
    {
        return $file->storeAs($path,$prefix.time().'.'.$file->extension(),static::$disk);
    }

    /**
     * @param string $file
     * @return string
     */
    static function url(string $file) : string
    {
        return Storage::disk(static::$disk)->url($file);
    }

    /**
     * @param string|null $file
     * @return bool
     */
    static function delete (?string $file): bool
    {
        if (!$file){
            return false;
        }
        return Storage::disk(static::$disk)->delete($file);
    }
}
