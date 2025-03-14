<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\Admin\RoleService;
use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\Role\CreateRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected $roleService;
    protected $permissionService;

    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('role-list'), only:['index']),
            new Middleware(PermissionMiddleware::using('role-create'), only:['store']),
            new Middleware(PermissionMiddleware::using('role-edit'), only:['update']),
        ];
    }

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['role_counts'] = $this->roleService->getRolesWithUserCount();
        $data['roles'] = $this->roleService->getRoles($request);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $this->roleService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $data['role'] = $role;
        $data['rolePermissions'] = $role->permissions;

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($role, $request->all());
        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPermissions()
    {
        $permissions = $this->permissionService->getPermissions()->groupBy('category');

        return response()->success('Success!', Response::HTTP_OK, $permissions);
    }
}
