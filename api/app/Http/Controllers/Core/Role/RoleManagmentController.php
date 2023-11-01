<?php

namespace App\Http\Controllers\Core\Role;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Repository\Role\RoleRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleResource;
use App\Http\Controllers\JsonResponseTrait;
use Repository\Permission\PermissionRepository;
use App\Http\Requests\Role\RoleCreateOrUpdateRequest;
use Illuminate\Http\Request;

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
    public function index()
    {
        Gate::authorize('view','roles');
        $roles =$this->roleRepository->getAll();
        return $this->json('List of role', RoleResource::collection($roles));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateOrUpdateRequest $request)
    {
        Gate::authorize('edit','roles');
        //role create with validated the data in RoleCreateOrUpdateRequest
        $role = $this->roleRepository->create($request->validated());
        if($permissions = $request->input('permissions')) {
            foreach(explode(',',$permissions) as $permission_id) {
                DB::table('role_permission')->insert([
                    'role_id' => $role['id'],
                    'permission_id' => $permission_id
                ]);
            }
        }
        return $this->json('Role create successfully',[
            'role'          => new RoleResource($role), 
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
        Gate::authorize('edit','roles');
        $role = $this->roleRepository->findByID($id);
        return $this->json("The role $id is",new RoleResource($role));
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
        Gate::authorize('edit','roles');
        //role update with validated the data in RoleCreateOrUpdateRequest
        $role = $this->roleRepository->updateByID($id, $request->all());
        DB:: table('role_permission')->where('role_id', $id)->delete();
        if($permissions = $request->input('permissions')) {
            foreach($permissions as $permission_id) {
                DB::table('role_permission')->insert([
                    'role_id' => $id,
                    'permission_id' => $permission_id
                ]);
            }
        }
        return $this->json('Role update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('edit','roles');
        //role delete
        DB:: table('role_permission')->where('role_id', $id)->delete();
        $this->roleRepository->deletedByID($id);
        return $this->json('Role delete successfully');
    }
}
