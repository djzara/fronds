<?php

declare(strict_types=1);

namespace Fronds\Http\Resources\Page;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Page
 *
 * @package Fronds\Http\Resources
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class Page extends JsonResource
{

    public function toArray($request)
    {
        return [
            'name' => $this->page_title,
            'slug' => $this->slug,
            'layout' => $this->page_layout,
            'id' => $this->id
        ];
    }
}
