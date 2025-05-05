<?php

namespace App\Services\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\UserRepository;
use App\Services\Interfaces\Admin\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
      * @var userRepository
      */
    protected $userRepository;

    /**
     * AppointmentService constructor.
     *
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(Request $request)
    {
        return $this->userRepository->getUsers($request);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create user');
        }
        DB::commit();

        return $result;
    }

    public function update(User $user, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRepository->update($user, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update user');
        }
        DB::commit();

        return $result;
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function changeStatus(User $user)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRepository->changeStatus($user);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to active user');
        }
        DB::commit();
        return $result;
    }

    //  public function destroy(User $user)
    //  {
    //      DB::beginTransaction();
    //      try {
    //          $result = $this->userRepository->destroy($user);
    //      } catch (Exception $exc) {
    //          DB::rollBack();
    //          Log::error($exc->getMessage());
    //          throw new InvalidArgumentException('Unable to delete user');
    //      }
    //      DB::commit();

    //      return $result;
    //  }

    public function getRoles()
    {
        return $this->userRepository->getRoles();
    }
}
