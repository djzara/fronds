<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Content;

use Fronds\Models\Page;
use Fronds\Repositories\Content\PageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class PageRepositoryTest
 *
 * @package Tests\Unit\Repositories\Content
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
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
        static::assertSame(Page::class, $this->repository->getModelClass());
    }

    /**
     * @param array $pageInfo
     * @dataProvider pageProvider
     */
    public function testCanGetGenericPageById(array $pageInfo): void
    {
        $page = $this->repository->writePage($pageInfo);
        $pageFromTable = $this->repository->getById($page->id);
        self::assertInstanceOf(Page::class, $pageFromTable);
        self::assertEquals($page->id, $pageFromTable->id);
    }

    /**
     * @param array $pageInfo
     * @dataProvider pageProvider
     */
    public function testAddPageValid(array $pageInfo): void
    {
        $page = $this->repository->writePage($pageInfo);
        self::assertEquals($page->page_title, $pageInfo['title']);
        self::assertEquals($page->slug, $pageInfo['slug']);
        self::assertEquals($page->page_layout, $pageInfo['layout']);
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
