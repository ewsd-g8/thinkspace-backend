<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Closure;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\ClosureRepository;
use App\Services\Interfaces\Admin\ClosureServiceInterface;

class ClosureService implements ClosureServiceInterface
{
    protected $closureRepository;

    public function __construct(ClosureRepository $closureRepository)
    {
        $this->closureRepository = $closureRepository;
    }

    public function getClosures($request)
    {
        $result = $this->closureRepository->getClosures($request);

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
        if (Closure::where('is_active', true)->exists()) {
            throw new InvalidArgumentException('An active closure already exists.');
        }
        
        DB::beginTransaction();
        try {
            $result = $this->closureRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create Closure');
        }
        DB::commit();

        return $result;
    }

    public function getClosure($id)
    {
        return $this->closureRepository->getClosure($id);
    }

    public function update(Closure $closure, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->closureRepository->update($closure, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update closure');
        }
        DB::commit();

        return $result;
    }

    public function changeStatus(Closure $closure)
    {
        DB::beginTransaction();
        try {
            $result = $this->closureRepository->changeStatus($closure);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to change closure status');
        }
        DB::commit();
        return $result;
    }

    public function getAllClosures()
    {
        return $this->closureRepository->getAllClosures();
    }
}
