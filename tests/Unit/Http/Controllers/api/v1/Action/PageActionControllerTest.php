<?php

namespace Tests\Unit\Http\Controllers\api\v1\Action;

use Carbon\Carbon;
use Faker\Provider\Uuid;
use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Exceptions\Data\FrondsCreateEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Services\ContentServices\PageService;
use Fronds\Models\Page;
use Tests\TestCase;

class PageActionControllerTest extends TestCase
{

    private $pageServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->pageServiceMock = $this->mock(PageService::class);
    }

    /**
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        Page::truncate();
        parent::tearDown();
    }

    public function testPageActionIndex(): void
    {
        $this->pageServiceMock->shouldReceive('pagesForDisplay')
            ->andReturn(
                [
                    'columns' => [
                        'Page Title',
                        'Slug'
                    ],
                    'hidden' => [
                        'layout',
                        'id'
                    ],
                    'values' => []
                ]
            );
        $response = $this->getJson('/api/v1/page');
        $response->assertOk()
            ->assertExactJson(
                [
                    'message' => __('widgets.action.panels.pages.responses.view_all'),
                    'data' => [
                        'columns' => [
                            'Page Title',
                            'Slug'
                        ],
                        'hidden' => [
                            'layout',
                            'id'
                        ],
                        'values' => []
                    ]
                ]
            );
    }

    public function testPageActionIndexException(): void
    {
        $this->pageServiceMock->shouldReceive('pagesForDisplay')
            ->andThrow(FrondsEntityException::class);
        $response = $this->getJson('/api/v1/page');
        $this->assertTrue($response->isServerError());
        $response->assertExactJson(
            [
                'message' => '',
                'data' => [
                    'error_code' => ExceptionConstants::FRONDS_DATA
                        | ExceptionConstants::FRONDS_ERROR,
                    'message' => ''
                ]
            ]
        );
    }

    public function testPageViewSingle(): void
    {
        $response = $this->get('/api/v1/page/1');
        $response->assertOk()
            ->assertExactJson(
                [
                    'message' => '',
                    'data' => []
                ]
            );
    }

    public function testPageActionStoreMissingAll(): void
    {
        // add no data to the request
        $response = $this->postJson('/api/v1/page');
        $response->assertStatus(422)
            ->assertExactJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'title' => [
                            __('validation.custom.title.required')
                        ],
                        'slug' => [
                            __('validation.custom.slug.required')
                        ],
                        'layout' => [
                            __('validation.custom.layout.required')
                        ]
                    ]
                ]
            );
    }

    /**
     * @dataProvider invalidPageUpdateProvider
     * @param  array  $invalidData
     */
    public function testPageActionStoreInvalidSlug(array $invalidData): void
    {
        $this->pageServiceMock->shouldReceive('addNewPage')
            ->with($invalidData)
            ->andReturn(Uuid::uuid());
        $response = $this->postJson('/api/v1/page', $invalidData);
        $response->assertStatus(422);
        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'slug' => [
                        'Invalid slug format'
                    ]
                ]
            ]
        );
    }

    public function testPageActionStoreDuplicateSlug(): void
    {
        factory(Page::class)->create(
            [
                'slug' => 'dupe-me'
            ]
        );
        $response = $this->postJson(
            '/api/v1/page',
            [
                'title' => 'dupe me',
                'slug' => 'dupe-me',
                'layout' => 'full-width'
            ]
        );
        $response->assertStatus(422);
        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'slug' => [
                        __('validation.custom.slug.unique')
                    ]
                ]
            ]
        );
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $validData
     */
    public function testPageActionStoreValidPage(array $validData): void
    {
        $pageId = Uuid::uuid();
        $this->pageServiceMock->shouldReceive('addNewPage')
            ->with($validData)
            ->andReturn($pageId);
        $response = $this->postJson('/api/v1/page', $validData);
        $response->assertCreated();
        $response->assertExactJson(
            [
                'message' => __('widgets.action.panels.pages.responses.add'),
                'data' => [
                    'page_id' => $pageId
                ]
            ]
        );
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $validData
     */
    public function testPageCreationException(array $validData): void
    {
        $this->pageServiceMock->shouldReceive('addNewPage')
            ->with($validData)
            ->andThrow(FrondsCreateEntityException::class, 'Could not create page, see logs for details');

        $response = $this->postJson('/api/v1/page', $validData);
        $response->assertStatus(500);
        $response->assertExactJson(
            [
                'message' => 'Could not create page, see logs for details',
                'data' => [
                    'error_code' => ExceptionConstants::COULD_NOT_CREATE
                        | ExceptionConstants::FRONDS_DATA
                        | ExceptionConstants::FRONDS_HALT,
                    'message' => 'Could not create page, see logs for details'
                ]
            ]
        );
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $validData
     */
    public function testPageUpdateInvalidId(array $validData): void
    {
        $uuid = Uuid::uuid();
        $this->pageServiceMock->shouldReceive('updatePage')
            ->with($validData, $uuid)->andReturn(false);
        $response = $this->putJson('/api/v1/page/'.$uuid, $validData);
        $response->assertStatus(500);
        $response->assertExactJson(
            [
                'message' => __('widgets.action.panels.pages.responses.edit_fail'),
                'data' => [
                    'error_code' => ExceptionConstants::FRONDS_DATA
                        | ExceptionConstants::FRONDS_ERROR,
                    'message' => __('widgets.action.panels.pages.responses.edit_fail')
                ]
            ]
        );
        $this->pageServiceMock->shouldReceive('updatePage')
            ->with($validData, $uuid)->andThrow(FrondsEntityException::class);
        $response = $this->putJson('/api/v1/page/'.$uuid, $validData);
        $response->assertStatus(500);
        $response->assertExactJson(
            [
                'message' => __('widgets.action.panels.pages.responses.edit_fail'),
                'data' => [
                    'error_code' => ExceptionConstants::FRONDS_DATA
                        | ExceptionConstants::FRONDS_ERROR,
                    'message' => __('widgets.action.panels.pages.responses.edit_fail')
                ]
            ]
        );
    }

    public function testPageActionUpdateMissingAll(): void
    {
        // add no data to the request
        $this->pageServiceMock->shouldReceive('updatePage');
        $response = $this->putJson('/api/v1/page/1');
        $response->assertStatus(422);
        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'title' => [
                        __('validation.custom.title.required')
                    ],
                    'slug' => [
                        __('validation.custom.slug.required')
                    ],
                    'layout' => [
                        __('validation.custom.layout.required')
                    ]
                ]
            ]
        );
    }

    /**
     * @dataProvider invalidPageUpdateProvider
     * @param  array  $invalidData
     */
    public function testPageActionUpdateInvalidSlug(array $invalidData): void
    {
        $this->pageServiceMock->shouldReceive('updatePage');
        $response = $this->putJson('/api/v1/page/1', $invalidData);
        $response->assertStatus(422);
        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'slug' => [
                        'Invalid slug format'
                    ]
                ]
            ]
        );
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $dupeData
     */
    public function testPageActionUpdateDuplicateSlug(array $dupeData): void
    {
        factory(Page::class)->create(
            [
                'slug' => 'test-title'
            ]
        );

        $this->pageServiceMock->shouldReceive('updatePage');
        $response = $this->putJson('/api/v1/page/1', $dupeData);
        $response->assertStatus(422);
        $response->assertExactJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'slug' => [
                        __('validation.custom.slug.unique')
                    ]
                ]
            ]
        );
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $validPage
     */
    public function testPageUpdateValidId(array $validPage): void
    {
        $uuid = Uuid::uuid();
        $this->pageServiceMock->shouldReceive('updatePage')
            ->with(
                $validPage,
                $uuid
            )
            ->andReturn(true);
        $response = $this->putJson(
            '/api/v1/page/'.$uuid,
            $validPage
        );
        $response->assertOk();
    }

    /**
     * @dataProvider validPageUpdateProvider
     * @param  array  $validPage
     */
    public function testPageUpdateException(array $validPage): void
    {
        $uuid = Uuid::uuid();
        $this->pageServiceMock->shouldReceive('updatePage')
            ->with(
                $validPage,
                $uuid
            )
            ->andThrow(FrondsEntityException::class);
        $response = $this->putJson(
            '/api/v1/page/'.$uuid,
            $validPage
        );
    }

    public function testPageDeleteMissingId(): void
    {
        $response = $this->deleteJson('/api/v1/page');

        $response->assertStatus(405);
        $response->assertJson(
            [
                'message' => 'The DELETE method is not supported for this route. Supported methods: GET, HEAD, POST.'
            ]
        );
    }

    public function testPageDelete(): void
    {
        $response = $this->delete(
            '/api/v1/page/1',
            [
                'page' => Uuid::uuid()
            ]
        );

        $response->assertOk();
        $response->assertExactJson(
            [
                'message' => '',
                'data' => []
            ]
        );
    }

    /**
     * @return array|string[][][]
     */
    public function validPageUpdateProvider(): array
    {
        return [
            [
                [
                    'title' => 'test title',
                    'slug' => 'test-title',
                    'layout' => 'full-width'
                ]
            ]
        ];
    }

    /**
     * @return array|string[][][]
     */
    public function invalidPageUpdateProvider(): array
    {
        return [
            [
                [
                    'title' => 'test title',
                    'slug' => 'this slug makes this one invalid',
                    'layout' => 'full-width'
                ]
            ]
        ];
    }
}
