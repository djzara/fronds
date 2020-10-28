<?php

declare(strict_types=1);

namespace Fronds\Repositories\Structure;

use Fronds\Lib\Exceptions\Data\FrondsCreateEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\MenuDefinition;
use Fronds\Repositories\FrondsRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class MenuDefinitionRepository
 *
 * @package Fronds\Repositories\Structure
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuDefinitionRepository extends FrondsRepository
{

    /**
     * @inheritDoc
     */
    public function getModelClass(): string
    {
        return MenuDefinition::class;
    }

    /**
     * @param  array  $menuDefinitionData
     * @return MenuDefinition
     * @throws FrondsException<FrondsCreateEntityException>
     */
    public function addMenuDef(array $menuDefinitionData): MenuDefinition
    {
        $result = MenuDefinition::create(
            ['menu_title' => $menuDefinitionData['title'], 'menu_type' => $menuDefinitionData['type']]
        );
        fronds_throw_unless($result !== false, FrondsCreateEntityException::class, 'Problem creating menu');
        return $result;
    }

    /**
     * @param  array|string[]  $columns
     * @param  int  $pageSize
     * @return LengthAwarePaginator
     * @throws FrondsException<FrondsEntityNotFoundException>
     */
    public function getMenuAssetListResults(array $columns = ['*'], int $pageSize = 10): LengthAwarePaginator
    {

        $result = MenuDefinition::select($columns)->with('items')->withCount('items')->paginate($pageSize);
        fronds_throw_if(
            $result === null,
            FrondsEntityNotFoundException::class,
            'Problem getting menus for asset list'
        );
        return $result;
    }

    /**
     * @param  string  $uuid
     * @return MenuDefinition
     * @throws FrondsException<FrondsEntityNotFoundException>
     */
    public function getSingleMenuDefByUuid(string $uuid): MenuDefinition
    {
        $menu = MenuDefinition::whereUuid($uuid)->with('items')->first();
        fronds_throw_if(
            $menu === null,
            FrondsEntityNotFoundException::class,
            'Could not find a menu def with that uuid'
        );
        return $menu;
    }

    /**
     * @param  string  $uuid
     * @return MenuDefinition
     * @throws FrondsException<FrondsEntityNotFoundException>
     */
    public function getBasicMenuDefByUuid(string $uuid): MenuDefinition
    {
        $menu = MenuDefinition::whereUuid($uuid)
            ->with('items:id,menu_definition_id,uuid,direct_to,external_link,label,list_order')
            ->first();
        fronds_throw_if(
            $menu === null,
            FrondsEntityNotFoundException::class,
            'Could not find a basic menu with that uuid'
        );
        return $menu;
    }

    /**
     * @param  string  $uuid
     * @param  array  $menuDef
     * @param  array  $menuItems
     * @throws FrondsException<FrondsEntityNotFoundException>
     */
    public function updateExistingMenuDef(string $uuid, array $menuDef, array $menuItems): void
    {
        $existingMenu = MenuDefinition::whereUuid($uuid)->first();
        fronds_throw_if(
            $existingMenu === null,
            FrondsEntityNotFoundException::class,
            'Invalid update id'
        );
        $data = [
                'menu_title' => $menuDef['title'],
                'menu_type' => $menuDef['type']
            ];
        if ($existingMenu->update($data)) {
            foreach ($menuItems as $menuItem) {
                $existingMenu->items()->updateOrCreate(['uuid' => $menuItem['uuid'] ?? null], $menuItem);
            }
        }
    }
}
