<?php

namespace Fronds\Http\Controllers\api\v1\Action;

use Fronds\Http\Controllers\api\ApiController;
use Fronds\Http\Requests\PageRequest;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Services\ContentServices\PageService;
use Illuminate\Http\JsonResponse;

class PageActionController extends ApiController
{

    /**
     * @var JsonResponse
     */
    private $currentResponse;

    /**
     * @var PageService
     */
    private $pageService;

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
        return $this->apiSuccess('');
    }

    /**
     * Save the new piece of content here
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function store(PageRequest $request): JsonResponse
    {
        $response = null;
        try {
            $pageId = $this->pageService->addNewPage($request->all());
            $this->currentResponse = $this->apiSuccess(
                __('widgets.action.panels.pages.responses.add'),
                ['page_id' => $pageId],
                HttpConstants::HTTP_CREATED);
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
        return $this->apiSuccess('');
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
