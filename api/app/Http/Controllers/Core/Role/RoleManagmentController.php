<?php

namespace App\Http\Controllers\Core\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Repository\Role\RoleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Role\RoleResource;
use App\Http\Controllers\JsonResponseTrait;
use Repository\Permission\PermissionRepository;
use App\Http\Requests\Role\RoleCreateOrUpdateRequest;

class RoleManagmentController extends Controller
{
    use JsonResponseTrait;

    protected $roleRepository, $permissionRepository;

    function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
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
            Gate::authorize('view', 'roles');
            $roles = $this->roleRepository->getAll($offset, $limit, $searchData, $option);
            $totalCount = $roles['count'];

            return $this->successJsonResponseWithLimitOffset('List of role', $option, $offset, $limit, $totalCount, RoleResource::collection($roles['result']));
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
    public function store(RoleCreateOrUpdateRequest $request)
    {
        try {
            Gate::authorize('edit', 'roles');
            $role = $this->roleRepository->create($request->validated());
            if ($permissions = $request->input('permissions')) {
                foreach ($permissions as $permission_id) {
                    DB::table('role_permission')->insert([
                        'role_id' => $role['id'],
                        'permission_id' => $permission_id
                    ]);
                }
            }
            return $this->createdJsonResponse('Role create successfully', [
                'role'          => new RoleResource($role),
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
            Gate::authorize('edit', 'roles');
            $role = $this->roleRepository->findByID($id);
            return $this->successJsonResponse("The role $id is", new RoleResource($role));
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
        DB::beginTransaction();

        try {
            Gate::authorize('edit', 'roles');
            $role = $this->roleRepository->updateByID($id, $request->all());

            DB::table('role_permission')->where('role_id', $id)->delete();

            if ($permissions = $request->input('permissions')) {
                foreach ($permissions as $permission_id) {
                    DB::table('role_permission')->insert([
                        'role_id' => $id,
                        'permission_id' => $permission_id
                    ]);
                }
            }

            DB::commit();

            return $this->createdJsonResponse('Role update successfully', [
                'role' => new RoleResource($role),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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
            Gate::authorize('edit', 'roles');
            DB::table('role_permission')->where('role_id', $id)->delete();
            $this->roleRepository->deletedByID($id);
            return $this->successJsonResponse('Role delete successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }
}
