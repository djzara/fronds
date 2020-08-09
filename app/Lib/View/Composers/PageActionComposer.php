<?php

declare(strict_types=1);

namespace Fronds\Lib\View\Composers;

use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Services\ContentServices\PageService;
use Illuminate\View\View;

class PageActionComposer
{

    /**
     * @var PageService
     */
    private PageService $pageService;

    /**
     * PageActionComposer constructor.
     * @param  PageService  $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @param  View  $view
     * @codeCoverageIgnore
     */
    public function compose(View $view): void
    {
        try {
            $view->with('pageList', $this->pageService->pagesForDisplay());
        } catch (FrondsException $e) {
            $view->with('pageList', []);
        }
    }
}
