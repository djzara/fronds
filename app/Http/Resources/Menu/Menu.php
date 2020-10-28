<?php

declare(strict_types=1);

namespace Fronds\Http\Resources\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Menu
 *
 * @package Fronds\Http\Resources\Menu
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class Menu extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->menu_title,
            'type' => ucfirst($this->menu_type),
            'num_items' => $this->items_count,
            'id' => $this->uuid
        ];
    }
}
