<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ReportType\CreateReportTypeRequest;
use App\Http\Requests\Admin\ReportType\UpdateReportTypeRequest;
use App\Services\Admin\ReportTypeService;
use App\Models\ReportType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReportTypeController extends Controller implements HasMiddleware
{
    protected $reportTypeService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:reportType-list', only: ['index', 'show']),
            new Middleware('permission:reportType-create', only: ['store']),
            new Middleware('permission:reportType-edit', only: ['update'])
        ];
    }

    public function __construct(ReportTypeService $reportTypeService)
    {
        $this->reportTypeService = $reportTypeService;
    }
    
    public function index(Request $request)
    {
        $reportTypes = $this->reportTypeService->getReportTypes($request);

        return response()->success('Success!', Response::HTTP_OK, $reportTypes);
    }

    public function store(CreateReportTypeRequest $request)
    {
        $reportType = $this->reportTypeService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK, $reportType);
    }

    public function show(string $id)
    {
        $data = $this->reportTypeService->getReportType($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    public function update(UpdateReportTypeRequest $request, ReportType $reportType)
    {
        $updated = $this->reportTypeService->update($reportType, $request->all());

        return response()->success('Success!', Response::HTTP_OK, $updated);
    }

    public function getAllReportTypes()
    {
        $data = $this->reportTypeService->getAllReportTypes();

        return response()->success('Success', Response::HTTP_OK, $data); 
    }
}
