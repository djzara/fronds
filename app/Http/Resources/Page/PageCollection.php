<?php

namespace Fronds\Http\Resources\Page;

use Fronds\Http\Resources\Page\Page as PageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PageCollection
 *
 * @package Fronds\Http\Resources\Page
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class PageCollection extends ResourceCollection
{

    /**
     * @var string
     */
    public $collects = PageResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
