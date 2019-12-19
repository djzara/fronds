<?php

namespace Tests\Unit\Services\ContentServices;

use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\Page;
use Fronds\Repositories\Content\PageRepository;
use Fronds\Services\ContentServices\PageService;
use Tests\TestCase;

class PageServiceTest extends TestCase
{

    /**
     * @var \Mockery\MockInterface|PageRepository
     */
    private $pageRepositoryMock;

    /**
     * @var PageService
     */
    private $pageService;

    public function setUp(): void
    {
        parent::setUp();
        $this->pageRepositoryMock = $this->mock(PageRepository::class);
        $this->pageService = new PageService($this->pageRepositoryMock);
    }

    public function testAddPageEmptyData(): void
    {
        $this->pageRepositoryMock->shouldReceive('addPage')
            ->with([])
            ->andThrow(FrondsEntityException::class);
        $this->expectException(FrondsEntityException::class);
        $this->pageService->addNewPage([]);
    }

    public function testAddPageValidData(): void
    {
        $factoryPage = factory(Page::class)->create();
        $this->pageRepositoryMock->shouldReceive('addPage')
            ->with(['page_title' => $factoryPage->page_title,
                'slug' => $factoryPage->slug,
                'page_layout' => $factoryPage->page_layout])
            ->andReturn($factoryPage);
        try {
            $pageId = $this->pageService->addNewPage(['page_title' => $factoryPage->page_title,
                'slug' => $factoryPage->slug,
                'page_layout' => $factoryPage->page_layout]);
            $this->assertEquals($factoryPage->id, $pageId);
        } catch (FrondsEntityException $e) {
            $this->fail($e->getMessage());
        } catch (FrondsException $e) {
            $this->fail('Unknown exception occurred');
        }
    }
}
