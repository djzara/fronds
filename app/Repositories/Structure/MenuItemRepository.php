<?php

declare(strict_types=1);

namespace Fronds\Repositories\Structure;

use Fronds\Lib\Exceptions\Data\FrondsCreateEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\MenuItem;
use Fronds\Repositories\FrondsRepository;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class MenuItemRepository
 *
 * @package Fronds\Repositories\Content
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuItemRepository extends FrondsRepository
{
    public function getModelClass(): string
    {
        return MenuItem::class;
    }

    /**
     * @param  array  $menuItemData
     * @param  int  $menuDefinitionId
     * @return MenuItem
     * @throws FrondsException<FrondsCreateEntityException>
     */
    public function addMenuItem(array $menuItemData, int $menuDefinitionId): MenuItem
    {
        $result = MenuItem::create(
            [
                'menu_definition_id' => $menuDefinitionId,
                'direct_to' => $menuItemData['direct_to'] ?? null,
                'external_link' => $menuItemData['external_link'] ?? null,
                'label' => $menuItemData['label'] ?? '',
                'list_order' => $menuItemData['list_order'] ?? 0,
            ]
        );
        fronds_throw_if($result === null, FrondsCreateEntityException::class, 'Error creating menu item');
        return $result;
    }

    /**
     * @param  string  $menuItemId
     * @return bool
     * @throws FrondsException<FrondsEntityNotFoundException>
     */
    public function removeMenuItem(string $menuItemId): bool
    {
        $result = MenuItem::whereUuid($menuItemId)->delete();
        fronds_throw_if($result === null, FrondsEntityNotFoundException::class, 'No item to remove');
        return $result;
    }
}
