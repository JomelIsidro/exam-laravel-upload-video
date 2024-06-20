<?php

namespace App\Http\Controllers;

use App\Services\VideoUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoUploadController extends Controller
{
    protected $videoUploadService;

    public function __construct(VideoUploadService $videoUploadService)
    {
        $this->videoUploadService = $videoUploadService;
    }

    public function upload(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimetypes:video/*',
        ]);

        // Check if the validator fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // If validation passes, proceed with handling the upload
        $result = $this->videoUploadService->handleUpload($request);

        // Return success response with a message
        return response()->json([
            'message' => 'Video successfully uploaded!',
            'data' => $result
        ]);
    }
}
