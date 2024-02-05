<?php

declare(strict_types=1);

namespace App\Http\Controllers\Core\Permission;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Repository\Permission\PermissionRepository;
use App\Http\Resources\Permission\PermissionResource;
use App\Http\Requests\Permission\PermissionCreateOrUpdateRequest;

class PermissionManagmentController extends Controller
{
    use JsonResponseTrait;

    protected $permissionRepository;

    function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset         = $request['offset'];
        $limit          = $request['limit'];
        $option         = $request['option'];
        $searchData     = $request['searchData'];

        try {
            Gate::authorize('view','permissions');
            $permissions = $this->permissionRepository->getAll($offset, $limit, $searchData, $option);
            $totalCount = $permissions['count'];

            return $this->successJsonResponseWithLimitOffset('List of Permission', $option, $offset, $limit, $totalCount, PermissionResource::collection($permissions['result']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateOrUpdateRequest $request)
    {
        try {
            Gate::authorize('edit','permissions');
            $permission = $this->permissionRepository->create($request->validated());
            return $this->createdJsonResponse('Permission create successfully',[
                'permission'          => $permission, 
            ]);
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            Gate::authorize('view','permissions');
            $permission = $this->permissionRepository->findByID($id);
            return $this->successJsonResponse("The user $id is",new PermissionResource($permission));
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Gate::authorize('edit','permissions');
            $permission = $this->permissionRepository->updateByID($id, $request->all());
            return $this->createdJsonResponse('Permission update successfully',[
                'permission'          => $permission, 
            ]);
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Gate::authorize('edit','permissions');
            $this->permissionRepository->deletedByID($id);
            return $this->successJsonResponse('Permission delete successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }
}
