<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\CreateReportRequest;
use App\Models\Report;
use App\Services\Admin\ReportService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReportController extends Controller implements HasMiddleware
{
    protected $reportService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:report-list', only: ['index', 'show']),
            new Middleware('permission:report-create', only: ['store']),
            new Middleware('permission:report-edit', only: ['changeStatus'])
        ];

    }

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    
    public function index(Request $request)
    {
        $reports = $this->reportService->getReports($request);

        return response()->success('Success!', Response::HTTP_OK, $reports);
    }

    public function store(CreateReportRequest $request)
    {
        $report = $this->reportService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK, $report);
    }

    public function show(string $id)
    {
        $data = $this->reportService->getReport($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    public function changeStatus(Report $report)
    {
        $changedStatus = $this->reportService->changeStatus($report);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }
}
