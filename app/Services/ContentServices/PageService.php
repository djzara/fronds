<?php

namespace Fronds\Services\ContentServices;

use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Repositories\Content\PageRepository;
use Fronds\Services\FrondsService;

class PageService extends FrondsService
{

    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param array $pageData
     * @return string
     * @throws FrondsEntityException|FrondsException
     */
    public function addNewPage(array $pageData): string
    {
        return $this->pageRepository->addPage($pageData)->id;
    }
}
