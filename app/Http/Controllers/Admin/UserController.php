<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Admin\User\UserResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('user-list'), only:['index']),
            new Middleware(PermissionMiddleware::using('user-create'), only:['store']),
            new Middleware(PermissionMiddleware::using('user-edit'), only:['update', 'changeStatus']),
        ];
    }
    
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);

        return response()->success('Success!', Response::HTTP_OK, $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->userService->getUserById($id);
        $result = new UserResource($data);

        return response()->success('Success!', Response::HTTP_OK, $result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function changeStatus(User $user)
    {
        $this->userService->changeStatus($user);

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function getRoles()
    {
        $data = $this->userService->getRoles();

        return response()->success('Success!', Response::HTTP_OK, $data);
    }
}
