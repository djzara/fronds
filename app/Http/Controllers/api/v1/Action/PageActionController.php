<?php

namespace Fronds\Http\Controllers\api\v1\Action;

use Carbon\Carbon;
use Fronds\Http\Controllers\api\ApiController;
use Fronds\Http\Requests\PageRequest;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Services\ContentServices\PageService;
use Illuminate\Http\JsonResponse;

/**
 * Class PageActionController
 *
 * @package Fronds\Http\Controllers\api\v1\Action
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class PageActionController extends ApiController
{

    /**
     * @var PageService
     */
    private PageService $pageService;

    /**
     * PageActionController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Grab any content items associated with this action
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $pages = $this->pageService->pagesForDisplay(request()->input('page_size', 10));
            $this->currentResponse = $this->apiSuccess(
                __('widgets.action.panels.pages.responses.view_all'),
                $pages
            );
            return $this->currentResponse;
        } catch (FrondsException $frondsException) {
            $this->currentResponse = $this->apiError($frondsException);
            return $this->currentResponse;
        }
    }

    /**
     * Save the new piece of content here
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function store(PageRequest $request): JsonResponse
    {
        try {
            $pageId = $this->pageService->addNewPage($request->all());
            $this->currentResponse = $this->apiSuccess(
                __('widgets.action.panels.pages.responses.add'),
                ['page_id' => $pageId],
                HttpConstants::HTTP_CREATED
            );
            return $this->currentResponse;
        } catch (FrondsException $frondsException) {
            $this->currentResponse = $this->apiError($frondsException);
            return $this->currentResponse;
        }
    }

    /**
     * If you need to retrieve content in an API friendly format, use this
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->apiSuccess('');
    }

    /**
     * Update the content by id
     * @param PageRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PageRequest $request, $id): JsonResponse
    {
        try {
            $updateResult = $this->pageService->updatePage($request->all(), $id);
            if ($updateResult) {
                $this->currentResponse = $this->apiSuccess(
                    __('widgets.action.panels.pages.responses.edit'),
                    [
                    'updated_at' => Carbon::now(),
                    'original' => $request->all()
                    ]
                );
            } else {
                $this->currentResponse = $this->apiError(
                    new FrondsEntityException(__('widgets.action.panels.pages.responses.edit_fail'))
                );
            }
            return $this->currentResponse;
        } catch (FrondsException $frondsException) {
            $this->currentResponse = $this->apiError($frondsException);
            return $this->currentResponse;
        }
    }

    /**
     * Delete content by id
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->apiSuccess('');
    }
}
