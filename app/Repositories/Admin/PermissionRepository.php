<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Get permission lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPermissions()
    {
        return Permission::orderBy('category', 'asc')->get();
    }

    /**
     * Get role of permission lists.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
    }
}
