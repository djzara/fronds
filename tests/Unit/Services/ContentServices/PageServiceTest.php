<?php

namespace Tests\Unit\Services\ContentServices;

use Faker\Provider\Uuid;
use Fronds\Http\Resources\Page\PageCollection;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\Page;
use Fronds\Repositories\Content\PageRepository;
use Fronds\Services\ContentServices\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Class PageServiceTest
 *
 * @package Tests\Unit\Services\ContentServices
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class PageServiceTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @var MockInterface|PageRepository
     */
    private $pageRepositoryMock;

    /**
     * @var PageService
     */
    private PageService $pageService;

    public function setUp(): void
    {
        parent::setUp();
        $this->pageRepositoryMock = $this->mock(PageRepository::class);
        $this->pageService = new PageService($this->pageRepositoryMock);
    }

    public function testAddPageEmptyData(): void
    {
        $this->pageRepositoryMock->shouldReceive('writePage')
            ->with([])
            ->andThrow(FrondsEntityException::class);
        $this->expectException(FrondsEntityException::class);
        $this->pageService->addNewPage([]);
    }

    public function testAddPageValidData(): void
    {
        $factoryPage = Page::factory()->create();
        $this->pageRepositoryMock->shouldReceive('writePage')
            ->with(['page_title' => $factoryPage->page_title,
                'slug' => $factoryPage->slug,
                'page_layout' => $factoryPage->page_layout])
            ->andReturn($factoryPage);
        try {
            $pageId = $this->pageService->addNewPage(['page_title' => $factoryPage->page_title,
                'slug' => $factoryPage->slug,
                'page_layout' => $factoryPage->page_layout]);
            self::assertEquals($factoryPage->id, $pageId);
        } catch (FrondsEntityException $e) {
            self::fail($e->getMessage());
        } catch (FrondsException $e) {
            self::fail('Unknown exception occurred');
        }
    }

    public function testGetPagesForDisplayPaginated(): void
    {
        Page::factory()->count(5)->create();
        $this->pageRepositoryMock->shouldReceive('getAllPagesPaginated')
            ->with(['page_title', 'slug', 'page_layout', 'id'], 2)
            ->andReturn(Page::paginate(2, ['page_title', 'slug', 'page_layout', 'id'], ['pagination_page']));
        $pageResults = $this->pageService->getForDisplay(true, 2);
        self::assertArrayHasKey('values', $pageResults);
        self::assertArrayHasKey('columns', $pageResults);
        self::assertArrayHasKey('hidden', $pageResults);
        self::assertInstanceOf(PageCollection::class, $pageResults['values']);
        self::assertEquals(2, $pageResults['values']->count());
    }

    public function testGetPagesForDisplayNotPaginated(): void
    {
        Page::factory()->count(5)->create();
        $this->pageRepositoryMock->shouldReceive('getAll')
            ->with(['page_title', 'slug', 'page_layout', 'id'])
            ->andReturn(Page::all());
        $pageResults = $this->pageService->getForDisplay(false);
        self::assertArrayHasKey('values', $pageResults);
        self::assertArrayHasKey('columns', $pageResults);
        self::assertArrayHasKey('hidden', $pageResults);
        self::assertCount(5, $pageResults['values']);
    }

    public function testUpdatePageValidData(): void
    {
        $pageId = Uuid::uuid();
        $pageData = ['title' => 'the page', 'slug' => 'the-page', 'layout' => 'two-column'];
        $initialPage = Page::factory()->create(
            [
                'id' => $pageId,
                'page_title' => 'original title',
                'slug' => 'original-title'
            ]
        );$this->pageRepositoryMock->shouldReceive('writePage')
            ->with(['id' => $pageId, 'title' => 'the page', 'slug' => 'the-page', 'layout' => 'two-column'])
            ->andReturn(
                Page::updateOrCreate(
                    ['id' => $initialPage->id],
                    [
                        'page_title' => 'the page',
                        'the-page'
                    ]
                )
            );
        self::assertTrue($this->pageService->updatePage($pageData, $pageId));
    }
}
