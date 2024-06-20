<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoUploadService
{
    public function handleUpload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = 'uploads/' . $fileName;

        Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        return ['status' => 'file uploaded', 'path' => Storage::url($filePath)];
    }
}
