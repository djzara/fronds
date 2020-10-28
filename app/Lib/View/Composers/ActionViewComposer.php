<?php

declare(strict_types=1);

namespace Fronds\Lib\View\Composers;

use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Services\ContentServices\PageService;
use Fronds\Services\DisplaysList;
use Fronds\Services\StructureServices\MenuService;
use Illuminate\View\View;
use Log;

/**
 * Class ActionViewComposer
 *
 * @package Fronds\Lib\View\Composers
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class ActionViewComposer
{

    /**
     * @var array<DisplaysList>
     */
    private array $lists = [];

    /**
     * ActionViewComposer constructor.
     * @param  PageService  $pageService
     * @param  MenuService  $menuService
     */
    public function __construct(PageService $pageService, MenuService $menuService)
    {
        $this->lists[] = $pageService;
        $this->lists[] = $menuService;
    }

    /**
     * @param  View  $view
     * @codeCoverageIgnore
     */
    public function compose(View $view): void
    {
        try {
            foreach ($this->lists as $actionDataList) {
                $view->with($actionDataList->getListParamName(), $actionDataList->getForDisplay());
            }
        } catch (FrondsException $exception) {
            Log::error($exception->getMessage());
            foreach ($this->lists as $actionDataList) {
                $view->with($actionDataList->getListParamName(), []);
            }
        }
    }
}
