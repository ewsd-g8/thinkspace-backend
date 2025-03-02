<?php

namespace App\Services\Interfaces\Admin;

use App\Models\User;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function getUsers(Request $request);
    public function getUserById($id);
    public function create(array $data);
    public function update(User $user, array $data);
    public function changeStatus(User $user);
    public function getRoles();
    public function changeBlockStatus(User $user);
    public function changeHiddenStatus(User $user);
    public function getDepartments();
}
