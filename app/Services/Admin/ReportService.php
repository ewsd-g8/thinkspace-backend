<?php

namespace App\Services\Admin;

use App\Models\Report;
use App\Services\Interfaces\Admin\ReportServiceInterface;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\ReportRepository;

class ReportService implements ReportServiceInterface
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getReports($request)
    {
        $result = $this->reportRepository->getReports($request);

        return $result;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->reportRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create report');
        }
        DB::commit();

        return $result;
    }

    public function getReport($id)
    {
        return $this->reportRepository->getReport($id);
    }

    public function changeStatus(Report $report)
    {
        DB::beginTransaction();
        try {
            $result = $this->reportRepository->changeStatus($report);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to change report status');
        }
        DB::commit();
        return $result;
    }
}
