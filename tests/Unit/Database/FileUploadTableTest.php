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

    public function testAddFileUpload(): void
    {
        $fileUpload = factory(FileUpload::class)->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteFileUpload(): void
    {
        $fileUpload = factory(FileUpload::class)->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
        $fileUpload->delete();
        $this->assertDatabaseMissing('file_uploads', ['deleted_at' => null, 'id' => $fileUpload->id]);
        $fileUpload->forceDelete();
        $this->assertDatabaseMissing('file_uploads', ['id' => $fileUpload->id]);
    }

}
