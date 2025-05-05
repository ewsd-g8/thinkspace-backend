<?php

namespace App\Repositories\Admin;

use App\Models\Role;

class RoleRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Get lists of carPost.
     *
     * @return Collection | static []
     */

    public function getRoles($request)
    {
        $roles = Role::adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $roles = $roles->paginate(request()->get('paginate'));
        } else {
            $roles = $roles->paginate(10);
        }

        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function create(array $data): Role
    {
        $role = Role::create([
            'name'   => $data['name'],
        ]);
        $role->syncPermissions($data['permission']);
        return $role;
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
        $role->name = isset($data['name']) ? $data['name'] : $role->name;

        if ($role->isDirty()) {
            $role->save();
        }

        $role->syncPermissions($data['permission']);
        return $role;
    }
}
