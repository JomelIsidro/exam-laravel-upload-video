<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoUploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpload()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');

        $response = $this->postJson('/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Video successfully uploaded!',
                'data' => [
                    'status' => 'file uploaded',
                    'path' => '/storage/uploads/video.mp4',
                ]
            ]);


        Storage::disk('public')->assertExists('uploads/video.mp4');
    }
}
