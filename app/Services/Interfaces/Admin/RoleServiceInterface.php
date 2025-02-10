<?php

namespace App\Services\Interfaces\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

interface RoleServiceInterface
{
    public function getRolesWithUserCount();
    public function getRoles(Request $request);
    public function getRolesPluckName();
    public function create(array $data);
    public function update(Role $role, array $data);
}
