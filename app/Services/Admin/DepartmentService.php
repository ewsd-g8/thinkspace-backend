<?php

namespace App\Services\Admin;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\DepartmentRepository;
use App\Services\Interfaces\Admin\DepartmentServiceInterface;

class DepartmentService implements DepartmentServiceInterface
{
    /**
      * @var departmentRepository
      */
    protected $departmentRepository;

    /**
     * AppointmentService constructor.
     *
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartments(Request $request)
    {
        return $this->departmentRepository->getDepartments($request);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->departmentRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create department');
        }
        DB::commit();

        return $result;
    }

    public function update(Department $department, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->departmentRepository->update($department, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update department');
        }
        DB::commit();

        return $result;
    }

    public function getDepartmentById($id)
    {
        return $this->departmentRepository->getDepartmentById($id);
    }

}
