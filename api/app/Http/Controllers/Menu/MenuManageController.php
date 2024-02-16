<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\DB;
use Repository\Menu\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Menu\MenuResource;
use Repository\MenuItem\MenuItemRepository;
use App\Http\Requests\Menu\MenuCreateOrUpdateRequest;

class MenuManageController extends Controller
{
    use JsonResponseTrait;
    protected $menuRepository, $menuItemRepository;
    public function __construct(MenuRepository $menuRepository, MenuItemRepository $menuItemRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->menuItemRepository = $menuItemRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $offset = $request['offset'];
        $limit = $request['limit'];
        $option = $request['option'];
        $searchData = $request['searchData'];

        try {
            // Gate::authorize('view', 'menus');
            $menus = $this->menuRepository->getAll($offset, $limit, $searchData, $option);
            $totalCount = $menus['count'];
            return $this->successJsonResponseWithLimitOffset('List of menus', $option, $offset, $limit, $totalCount, MenuResource::collection($menus['result']));
        } catch (\Exception $e) {

            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuCreateOrUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!empty($request->parent_id)) {
                $menu = $this->menuRepository->create(
                    $request->validated() + [
                        "ordering" => $request->ordering
                    ]
                );
                // If menu creation is successful, proceed to handle role assignments
                if ($menu) {
                    // Attach roles to the menu
                    $roles = $request->input('role_id', []);
                    $menu->attachRolesToTheMenu()->attach($roles, ['parent_id' => $request->input('parent_id')]);
                }
                DB::rollBack();
            } else {
                $menu = $this->menuRepository->create(
                    $request->validated() + [
                        "ordering" => $request->ordering,
                    ]
                );
                if ($menu) {
                    // Attach roles to the menu
                    $roles = $request->input('role_id', []);
                    $menu->attachRolesToTheMenu()->attach($roles);
                }
                DB::rollBack();
            }
            DB::commit();
            return $this->createdJsonResponse('Menu create successfully', new MenuResource($menu));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $menu = $this->menuRepository->findByID($id);
            return $this->successJsonResponse("The menu id is: $id", new MenuResource($menu));
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (empty($request->parent_id)) {
                $menu = $this->menuRepository->updateByID(
                    $id,
                    $request->validated() + [
                        "parent_id" => $request->parent_id,
                        "ordering" => $request->ordering
                    ]
                );
            } else {
                $menu = $this->menuRepository->updateByID(
                    $id,
                    $request->validated() + [
                        "role_id" => $request->role_id,
                        "ordering" => $request->ordering,
                        "parent_id" => $request->parent_id
                    ]
                );
            }

            return $this->createdJsonResponse('Menu create successfully', new MenuResource($menu));
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Gate::authorize('edit', 'menus');
            $this->menuRepository->deletedByID($id);
            return $this->successJsonResponse('Menu delete successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }
}
