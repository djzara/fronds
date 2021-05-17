<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Fronds\Models\Page;
use Tests\TestCase;

/**
 * Class PageTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class PageTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddPage(): void
    {
        $page = Page::factory()->create();
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeletePage(): void
    {
        $page = Page::factory()->create();
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
        $page->forceDelete();
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
