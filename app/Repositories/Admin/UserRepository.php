<?php

namespace App\Repositories\Admin;

use App\Models\Role;
use App\Models\User;
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

    /**
     * Get lists of carPost.
     *
     * @return Collection | static []
     */

    public function getUsers($request)
    {
        $users = User::select('id', 'name', 'email', 'mobile', 'is_active')->with(['roles' => function ($q) {
            $q->select('name');
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
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'mobile' => isset($data['mobile']) ? $data['mobile'] : null,
            'is_active' => Status::Active,
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

        $role_array = [];
        $role_array[] = $data['roles'];
        $user->assignRole($role_array);

        return $user;
    }

    public function getUserById($id)
    {
        return User::with('roles')->where('id', $id)->first();
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
}
