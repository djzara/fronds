<?php

namespace Fronds\Repositories\Content;

use Fronds\Http\Resources\Page\PageCollection;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Lib\Exceptions\Usage\FrondsIllegalArgumentException;
use Fronds\Models\Page;
use Fronds\Repositories\FrondsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

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
     * @throws FrondsException
     */
    public function writePage(array $pageData): Page
    {
        $page = Page::updateOrCreate(['id' => $pageData['id'] ?? ''], [
            'page_title' => $pageData['title'],
            'slug' => $pageData['slug'],
            'page_layout' => $pageData['layout']
        ]);
        fronds_throw_if(
            $page === null,
            FrondsEntityException::class,
            'Could not create or update page, see logs for details'
        );
        return $page;
    }

    // TODO: allow by user, currently relationships not supported for this type

    /**
     * @param  array  $columns
     * @param  int  $pageSize
     * @return LengthAwarePaginator|PageCollection
     * @throws FrondsException
     */
    public function getAllPagesPaginated(array $columns = [], int $pageSize = 10): LengthAwarePaginator
    {
        fronds_throw_unless(
            $pageSize >= 0,
            FrondsIllegalArgumentException::class,
            'Invalid page size. Should be greater than or equal to 0'
        );

        return Page::paginate($pageSize, $columns, ['pagination_page']);
    }
}
