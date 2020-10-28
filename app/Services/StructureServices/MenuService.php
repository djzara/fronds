<?php

declare(strict_types=1);

namespace Fronds\Services\StructureServices;

use Fronds\Http\Resources\Menu\MenuCollection;
use Fronds\Lib\Exceptions\Data\FrondsCreateEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Repositories\Structure\MenuDefinitionRepository;
use Fronds\Repositories\Structure\MenuItemRepository;
use Fronds\Services\DisplaysList;
use Fronds\Services\FrondsService;

/**
 * Class MenuService
 *
 * @package Fronds\Services\ContentServices
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuService extends FrondsService implements DisplaysList
{

    private MenuDefinitionRepository $menuDefRepo;
    private MenuItemRepository $menuItemRepo;

    public function __construct(MenuDefinitionRepository $menuDefRepo, MenuItemRepository $menuItemRepo)
    {
        $this->menuDefRepo = $menuDefRepo;
        $this->menuItemRepo = $menuItemRepo;
    }

    /**
     * Creates a new site wide menu
     * @param  array  $menuDefData
     * @param  array  $menuItems
     * @return string
     * @throws FrondsCreateEntityException
     * @throws FrondsException
     */
    public function createNewSiteMenu(array $menuDefData, array $menuItems): string
    {
        $menuDef = $this->menuDefRepo->addMenuDef($menuDefData);
        foreach ($menuItems as $menuItem) {
            $this->menuItemRepo->addMenuItem($menuItem, $menuDef->id);
        }

        if ($menuDef->uuid) {
            return (string) $menuDef->uuid;
        }
        throw new FrondsCreateEntityException('Problem creating new menu');
    }

    /**
     * @param  bool  $paginated
     * @param  int  $pageSize
     * @return array
     * @throws FrondsException
     */
    public function getForDisplay(bool $paginated = true, int $pageSize = 10): array
    {
        $menus = $this->menuDefRepo->getMenuAssetListResults(['uuid', 'menu_title', 'menu_type'], $pageSize);
        $menusToDisplay = [
            'columns' => [
                'Title',
                'Type',
                'Item Count'
            ],
            'hidden' => [
                'id'
            ],
            'values' => []
        ];
        if ($paginated) {
            $menusToDisplay['values'] = new MenuCollection($menus);
        }
        return $menusToDisplay;
    }

    public function getListParamName(): string
    {
        return 'menuList';
    }
}
