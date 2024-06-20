<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\VideoUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoUploadServiceTest extends TestCase
{
    public function testHandleUpload()
    {
        // Simulate the public storage disk
        Storage::fake('public');

        // Create a fake uploaded file
        $file = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');

        // Create a new request and populate it with the fake file
        $request = Request::create('/upload', 'POST', [], [], ['file' => $file]);

        // Instantiate the service
        $service = new VideoUploadService();

        // Call the handleUpload method with the request
        $response = $service->handleUpload($request);

        // Assert the response and check if the file exists in the fake storage
        $this->assertEquals('file uploaded', $response['status']);
        Storage::disk('public')->assertExists('uploads/video.mp4');
    }
}
