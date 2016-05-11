<?php
/**
 * Author: Xavier Au
 * Date: 20/4/2016
 * Time: 9:15 PM
 */

namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaServices
{
    private $basePath;

    /**
     * MediaServices constructor.
     * @param $basePath
     */
    public function __construct()
    {
        $this->basePath = env('PROFILE_PIC_STORAGE', 'profilePic');
    }


    public function storeProfilePic(UploadedFile $file)
    {
        $path = public_path()."/".$this->basePath;
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).".".$extension;
        $file->move($path, $fileName);
        return '/'.$this->basePath."/".$fileName;
    }

    public function storeFeedPhoto(UploadedFile $file)
    {
        $this->basePath = 'media';
        $path = public_path()."/".$this->basePath;
        if(!Storage::disk('local')->exists($path))
            Storage::makeDirectory($path);
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).".".$extension;
        $file->move($path, $fileName);
        return '/'.$this->basePath."/".$fileName;
    }
}