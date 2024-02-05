<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\DB;
use Repository\Menu\MenuRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Menu\MenuResource;
use Repository\MenuItem\MenuItemRepository;
use App\Http\Requests\Menu\MenuCreateOrUpdateRequest;

class MenuManageController extends Controller
{
    use JsonResponseTrait;
    protected $menuRepository;
    protected $menuItemRepository;
    public function __construct(MenuRepository $menuRepository, MenuItemRepository $menuItemRepository) {
        $this->menuRepository = $menuRepository;
        $this->menuItemRepository = $menuItemRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuCreateOrUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $menu = $this->menuRepository->create($request->validated());
            $this->menuItemRepository->create($request->validated()+["menu_id"=> $menu->id]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
