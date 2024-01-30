<?php

namespace App\Http\Controllers\Core\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\JsonResponseTrait;
use App\Http\Requests\User\UserCreateOrUpdateRequest;

class UserManagementController extends Controller
{
    use JsonResponseTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $offset         = $request['offset'];
        $limit          = $request['limit'];
        $option         = $request['option'];
        $searchData     = $request['searchData'];
        
        try {
            Gate::authorize('view', 'users');
            $users = $this->userRepository->getAll($offset, $limit, $searchData, $option);
            $totalCount = $users['count'];
            return $this->successJsonResponseWithLimitOffset('List of users', $option, $offset, $limit, $totalCount, UserResource::collection($users['result']));
        } catch (\Exception $e) {

            return $this->errorJsonResponse('Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateOrUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            Gate::authorize('edit', 'users');
            $user = $this->userRepository->create($request->validated() + ['password' => $this->userRepository->generateDefaultPassword()]);

            DB::commit();

            return $this->createdJsonResponse('User create successfully', new UserResource($user));
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
        Gate::authorize('view','users');
        $user = $this->userRepository->findByIDWithRole($id);
        return $this->json("The user $id is",new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit','users');
        //User update with validated the data in UserCreateOrUpdateRequest
        $user = $this->userRepository->updateByID($id, $request->all());
        return $this->json('User update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('edit','users');
        $this->userRepository->deletedByID($id);
        return $this->json('User delete successfully');
    }
}
