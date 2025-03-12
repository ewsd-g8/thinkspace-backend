<?php

namespace App\Repositories\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Enums\Status;
use App\Helpers\MediaHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Customer\v1\MediaRepository;

class UserRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getUsers($request)
    {
        $users = User::select('id', 'name', 'email', 'mobile', 'is_active', 'department_id', 'created_at', 'updated_at','is_blocked','is_hidden')->with(['roles','department' => function ($q) {
            $q->select('id', 'name');
        }])->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $users = $users->paginate(request()->get('paginate'));
        } else {
            $users = $users->paginate(10);
        }

        return $users;
    }

    public function create(array $data): User
    {
        $user = User::create([
            'name'  => $data['name'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'mobile' => isset($data['mobile']) ? $data['mobile'] : null,
            'password' => Hash::make($data['password']),
            'is_active' => Status::Active,
            'department_id' => $data['department_id'],
          
        ]);
        if (isset($data['profile'])) {
            //   $mediaRepository = new MediaRepository();
            //   $filepath = $mediaRepository->createFile($data['profile'], config('constants.STORAGE_PATH.USER'));
            //   $user->profile = $filepath;
            //   if ($user->isDirty()) {
            //       $user->save();
            //   }

            $mediaHelper = new MediaHelper($data['profile'], 'user_profile');
            $media = $mediaHelper->save();
            if ($media['status'] == false) {
                return response()->error($media['message'], Response::HTTP_BAD_REQUEST, ['profile' => ['Invalid format!']]);
            }

            $user->profile = $media['storage_path'];
            if ($user->isDirty()) {
                $user->save();
            }
        }

        $role_array = [];
        $role_array[] = $data['roles'];
        $user->assignRole($role_array);

        return $user;
    }

    public function update(User $user, array $data)
    {
        $user->name = isset($data['name']) ? $data['name'] : $user->name;
        $user->email = isset($data['email']) ? $data['email'] : $user->email;
        $user->mobile = isset($data['mobile']) ? $data['mobile'] : $user->mobile;
        $user->department_id = isset($data['department_id'])? $data['department_id'] : $user->department_id;
        if (isset($data['profile'])) {
            // if ($user->profile && Storage::disk('s3')->exists($user->profile)) {
            //     Storage::disk('s3')->delete($user->profile);
            // }
            // $mediaRepository = new MediaRepository();
            // $filepath = $mediaRepository->createFile($data['profile'], config('constants.STORAGE_PATH.USER'));
            // $user->profile = $filepath;
            // if ($user->isDirty()) {
            //     $user->save();
            // }

            $path = parse_url($user->profile, PHP_URL_PATH);
            $pathParts = explode('/', $path);
            $filepath = implode('/', array_slice($pathParts, 2));

            if ($filepath && Storage::exists($filepath)) {
                Storage::delete($filepath);
            }

            $mediaHelper = new MediaHelper($data['profile'], 'user_profile');
            $media = $mediaHelper->save();
            if ($media['status'] == false) {
                return response()->error($media['message'], Response::HTTP_BAD_REQUEST, ['profile' => ['Invalid format!']]);
            }

            $user->profile = $media['storage_path'];
            if ($user->isDirty()) {
                $user->save();
            }
        }
        if ($user->isDirty()) {
            $user->save();
        }

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']); // Use syncRoles to replace existing roles
        }
        return $user;
    }

    public function getUserById($id)
    {
        return User::with('roles', 'department:id,name')->where('id', $id)->first();
    }

    public function changeStatus(User $user)
    {
        if ($user->is_active == 0) {
            $user->update([
                'is_active' => 1,
            ]);

            return $user->refresh();
        } else {
            $user->update([
                'is_active' => 0,
            ]);

            $user->tokens()->delete();

            return $user->refresh();
        }
    }
    
    public function changeBlockStatus(User $user): void 
    {
        if ($user->is_blocked == 0) {
            $user->update([
                'is_blocked' => 1,
            ]);


        } else {
            $user->update([
                'is_blocked' => 0,
            ]);


        }
    }

    public function changeHiddenStatus(User $user): void
    {
        if ($user->is_hidden == 0) {
            $user->update([
                'is_hidden' => 1,
            ]);

            
        } else {
            $user->update([
                'is_hidden' => 0,
            ]);

        }
    }
    //  public function destroy(User $user)
    //  {
    //      $deleted = $this->deleteById($user->id);
    //      if ($deleted) {
    //          $user->save();
    //      }
    //  }

    public function getRoles()
    {
        return Role::latest()->get();
    }

    public function getDepartments()
    {
        return Department::latest()->get(); 
    }
}
