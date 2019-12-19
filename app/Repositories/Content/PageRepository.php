<?php

namespace Fronds\Repositories\Content;

use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\Page;
use Fronds\Repositories\FrondsRepository;

class PageRepository extends FrondsRepository
{

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Page::class;
    }

    /**
     * Services should only pass in valid data
     * @param array $pageData
     * @return Page
     * @throws FrondsException|FrondsEntityException
     */
    public function addPage(array $pageData): Page
    {
        $newPage = Page::create([
            'page_title' => $pageData['title'],
            'slug' => $pageData['slug'],
            'page_layout' => $pageData['layout']
        ]);
        fronds_throw_if($newPage === null,
            FrondsEntityException::class,
            'Could not create page, see logs for details');
        return $newPage;
    }

}
