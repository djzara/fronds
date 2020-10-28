<?php

declare(strict_types=1);

namespace Fronds\Http\Resources\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class MenuCollection
 *
 * @package Fronds\Http\Resources\Menu
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuCollection extends ResourceCollection
{

    public $collects = Menu::class;

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
