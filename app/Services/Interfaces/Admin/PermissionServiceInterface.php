<?php

namespace App\Services\Interfaces\Admin;

interface PermissionServiceInterface
{
    public function getPermissions();
    public function getRolePermissions($id);
}
