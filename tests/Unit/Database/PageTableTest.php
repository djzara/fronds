<?php
/**
 * User: zara
 * Date: 2019-02-25
 * Time: 17:07
 */

namespace Tests\Unit\Database;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Fronds\Models\Page;
use Tests\TestCase;

class PageTableTest extends TestCase
{
    use RefreshDatabase;

    public function testAddPage(): void
    {
        $page = factory(Page::class)->create();
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeletePage(): void
    {
        $page = factory(Page::class)->create();
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
        $page->forceDelete();
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }


}
