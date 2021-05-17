<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 19:12
 */

namespace Tests\Unit\Database;

use Fronds\Models\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FileUploadTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FileUploadTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddFileUpload(): void
    {
        $fileUpload = FileUpload::factory()->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteFileUpload(): void
    {
        $fileUpload = FileUpload::factory()->create();
        $this->assertDatabaseHas('file_uploads', ['id' => $fileUpload->id]);
        $fileUpload->delete();
        $this->assertDatabaseMissing('file_uploads', ['deleted_at' => null, 'id' => $fileUpload->id]);
        $fileUpload->forceDelete();
        $this->assertDatabaseMissing('file_uploads', ['id' => $fileUpload->id]);
    }
}
