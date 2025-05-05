<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\ReportType;
use App\Services\Interfaces\Admin\ReportTypeServiceInterface;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\ReportTypeRepository;

class ReportTypeService implements ReportTypeServiceInterface
{
    protected $ReportTypeRepository;

    public function __construct(ReportTypeRepository $reportTypeRepository)
    {
        $this->ReportTypeRepository = $reportTypeRepository;
    }

    public function getReportTypes($request)
    {
        $result = $this->ReportTypeRepository->getReportTypes($request);

        return $result;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->ReportTypeRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create report type');
        }
        DB::commit();

        return $result;
    }

    public function getReportType($id)
    {
        return $this->ReportTypeRepository->getReportType($id);
    }

    public function update(ReportType $reportType, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->ReportTypeRepository->update($reportType, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update report type');
        }
        DB::commit();

        return $result;
    }

    public function changeStatus(ReportType $reportType)
    {
        DB::beginTransaction();
        try {
            $result = $this->ReportTypeRepository->changeStatus($reportType);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to change report type status');
        }
        DB::commit();
        return $result;
    }

    public function getAllReportTypes()
    {
        return $this->ReportTypeRepository->getAllReportTypes();
    }
}
