<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:12
 */

namespace Tests\Unit\Database;


use Fronds\Models\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileUploadTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddFileUpload() : void {
        $fileUpload = factory(FileUpload::class)->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteFileUpload() : void {
        $fileUpload = factory(FileUpload::class)->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
        $fileUploadToDelete = FileUpload::whereId($fileUpload->id)->first();
        $fileUploadToDelete->delete();
        $this->assertDatabaseMissing('file_uploads', ['deleted_at' => null, 'id' => $fileUploadToDelete->id]);
        $fileUploadToDelete->forceDelete();
        $this->assertDatabaseMissing('file_uploads', ['id' => $fileUploadToDelete->id]);
    }

}