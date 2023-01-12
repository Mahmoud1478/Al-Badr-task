<?php

namespace Tests\Unit;

use App\Classes\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    private string $file;
    private string $disk_prefix = 'uploads/testing';
    protected function setUp(): void
    {
        parent::setUp();
        Upload::$disk = 'uploads_testing';
        $file = UploadedFile::fake()->image('testing.png');
        $this->file = Upload::file($file,'testing');
    }

    /** @test */
    public function upload_file()
    {
        $this->assertTrue(Storage::disk(Upload::$disk)->exists($this->file));
    }

    /** @test */
    public function delete_upload_file()
    {

        $this->assertTrue(Storage::disk(Upload::$disk)->exists($this->file));
        $this->assertTrue(Upload::delete($this->file));
    }

    /** @test */
    public function get_url()
    {
        $this->assertEquals(url($this->disk_prefix).'/'.$this->file , Upload::url($this->file));
    }
}
