<?php

declare(strict_types=1);

namespace Fronds\Http\Controllers\api\v1\Action;

use Fronds\Http\Controllers\api\ApiController;
use Fronds\Http\Requests\MenuRequest;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Repositories\Structure\MenuDefinitionRepository;
use Fronds\Repositories\Structure\MenuItemRepository;
use Fronds\Services\StructureServices\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MenuActionController
 *
 * @package Fronds\Http\Controllers\api\v1\Action
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuActionController extends ApiController
{

    private MenuDefinitionRepository $menuDefRepo;
    private MenuItemRepository $menuItemRepo;
    private MenuService $menuService;

    public function __construct(
        MenuDefinitionRepository $menuDefRepo,
        MenuItemRepository $menuItemRepo,
        MenuService $menuService
    ) {
        $this->menuDefRepo = $menuDefRepo;
        $this->menuItemRepo = $menuItemRepo;
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuRequest  $request
     * @return JsonResponse
     */
    public function store(MenuRequest $request): JsonResponse
    {
        $menuDefinition = $request->only(['title', 'type']);
        $menuItems = $request->input('items', []);
        try {
            $newMenuId = $this->menuService->createNewSiteMenu($menuDefinition, $menuItems);
            $this->currentResponse = $this->apiSuccess(
                'New menu created',
                ['id' => $newMenuId],
                HttpConstants::HTTP_CREATED
            );
            return $this->currentResponse;
        } catch (FrondsException $exception) {
            $this->currentResponse = $this->apiError($exception);
            return $this->currentResponse;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $singleMenu = $this->menuDefRepo->getBasicMenuDefByUuid($id);
            $this->currentResponse = $this->apiSuccess('Menu info retrieved', $singleMenu->toArray());
            return $this->currentResponse;
        } catch (FrondsException $exception) {
            $this->currentResponse = $this->apiError($exception);
            return $this->currentResponse;
        }
    }

    /**
     * @param  MenuRequest  $request
     * @param $id
     * @return JsonResponse
     */
    public function update(MenuRequest $request, $id): JsonResponse
    {
        try {
            $this->menuDefRepo
                ->updateExistingMenuDef($id, $request->only(['title', 'type']), $request->input('items'));
            $this->currentResponse = $this->apiSuccess('Update successful');
            return $this->currentResponse;
        } catch (FrondsException $exception) {
            $this->currentResponse = $this->apiError($exception);
            return $this->currentResponse;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id): JsonResponse
    {
        //
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroyMenuItem($id): JsonResponse
    {

    }
}
