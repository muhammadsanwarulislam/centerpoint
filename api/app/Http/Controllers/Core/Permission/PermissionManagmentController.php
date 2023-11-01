<?php

namespace App\Http\Controllers\Core\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\JsonResponseTrait;
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
    public function index()
    {
        Gate::authorize('view','permissions');
        $permissions =$this->permissionRepository->getAll();
        // return $this->json('List of Permission', $permissions);
        return $this->json('List of Permission', PermissionResource::collection($permissions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateOrUpdateRequest $request)
    {
        Gate::authorize('edit','permissions');
        //permission create with validated the data in PermissionCreateOrUpdateRequest
        $permission = $this->permissionRepository->create($request->validated());

        return $this->json('Permission create successfully',[
            'permission'          => $permission, 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('view','permissions');
        $permission = $this->permissionRepository->findByID($id);
        return $this->json("The user $id is",new PermissionResource($permission));
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
        Gate::authorize('edit','permissions');
        //permission update with validated the data in PermissionCreateOrUpdateRequest
        $permission = $this->permissionRepository->updateByID($id, $request->all());

        return $this->json('Permission update successfully',[
            'permission'          => $permission, 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('edit','permissions');
        //permission delete
        $this->permissionRepository->deletedByID($id);
        return $this->json('Permission delete successfully');
    }
}
