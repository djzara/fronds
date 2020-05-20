<?php

namespace Fronds\Http\Resources\Page;

use Fronds\Http\Resources\Page\Page as PageResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
{

    public $collects = PageResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }


}
