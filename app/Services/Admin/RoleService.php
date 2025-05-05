<?php

namespace App\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\RoleRepository;
use App\Services\Interfaces\Admin\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    /**
      * @var roleRepository
      */
    protected $roleRepository;

    /**
     * AppointmentService constructor.
     *
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getRolesPluckName()
    {
        return Role::pluck('name', 'name')->all();
    }

    public function getRoles($request)
    {
        $result = $this->roleRepository->getRoles($request);

        return $result;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->roleRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create role');
        }
        DB::commit();

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->roleRepository->update($role, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update role');
        }
        DB::commit();

        return $result;
    }

    /**
     * Get Roles with user counts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRolesWithUserCount()
    {
        return Role::withCount('users')->get();
    }
}
