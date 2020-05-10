<?php

namespace Tests\Unit\Repositories\Content;

use Fronds\Models\Page;
use Fronds\Repositories\Content\PageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRepositoryTest extends TestCase
{

    use RefreshDatabase;

    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = resolve(PageRepository::class);
    }

    public function testGetModelClass(): void
    {
        $this->assertSame(Page::class, $this->repository->getModelClass());
    }

    /**
     * @param array $pageInfo
     * @dataProvider pageProvider
     */
    public function testCanGetGenericPageById(array $pageInfo): void
    {
        $page = $this->repository->writePage($pageInfo);
        $pageFromTable = $this->repository->getById($page->id);
        $this->assertInstanceOf(Page::class, $pageFromTable);
        $this->assertEquals($page->id, $pageFromTable->id);
    }

    /**
     * @param array $pageInfo
     * @dataProvider pageProvider
     */
    public function testAddPageValid(array $pageInfo): void
    {
        $page = $this->repository->writePage($pageInfo);
        $this->assertEquals($page->page_title, $pageInfo['title']);
        $this->assertEquals($page->slug, $pageInfo['slug']);
        $this->assertEquals($page->page_layout, $pageInfo['layout']);
    }

    public function pageProvider(): array
    {
        return [
            [
                ['title' => 'title one', 'slug' => 'title-one', 'layout' => 'full-width']
            ]
        ];
    }
}
