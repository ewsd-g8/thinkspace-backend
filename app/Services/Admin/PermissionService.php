<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PermissionRepository;
use App\Services\Interfaces\Admin\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * PermissionService constructor.
     *
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get permission lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPermissions()
    {
        return $this->permissionRepository->getPermissions();
    }

    /**
     * Get role of permission lists.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissions($id)
    {
        return $this->permissionRepository->getRolePermissions($id);
    }
}
