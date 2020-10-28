<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Structure;

use Fronds\Models\MenuDefinition;
use Fronds\Repositories\Structure\MenuDefinitionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * Class MenuDefinitionRepositoryTest
 *
 * @package Tests\Unit\Repositories\Structure
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuDefinitionRepositoryTest extends TestCase
{

    use RefreshDatabase;

    private MenuDefinitionRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = resolve(MenuDefinitionRepository::class);
    }

    public function testReturnsCorrectClass(): void
    {
        self::assertEquals(MenuDefinition::class, $this->repository->getModelClass());
    }

    public function testSavesWithNoExceptions(): void
    {
        $result = $this->repository->addMenuDef(['title' => 'some title', 'type' => 'list']);
        self::assertEquals('some title', $result->menu_title);
        self::assertEquals('list', $result->menu_type);
        $result = $this->repository->addMenuDef(['title' => 'another title', 'type' => 'dropdown']);
        self::assertEquals('another title', $result->menu_title);
        self::assertEquals('dropdown', $result->menu_type);
    }

    public function testGetsPaginatorForAssetList(): void
    {
        $result = $this->repository->addMenuDef(['title' => 'another title', 'type' => 'dropdown']);
        self::assertNotEmpty($result);
    }

    public function testGetSingleDefByUUid(): void
    {
        $result = $this->repository->addMenuDef(['title' => 'another title', 'type' => 'dropdown']);
        $resultAfterSave = $this->repository->getSingleMenuDefByUuid($result->uuid);
        self::assertEquals($result->uuid, $resultAfterSave->uuid);
    }

    public function testGetBasicDefByUuid(): void
    {
        $result = $this->repository->addMenuDef(['title' => 'basic title', 'type' => 'dropdown']);
        // the only real difference between this and getSingleDefByUuid
        // is which parts of the relation come back, this one having less
        $singleMenuDef = $this->repository->getBasicMenuDefByUuid($result->uuid);
        self::assertEquals($result->uuid, $singleMenuDef->uuid);
        self::markTestIncomplete('Needs to also test relation fields present');
    }

    public function testCreateFullMenu(): void
    {
        self::markTestIncomplete('Pending factory creation');
    }
}
