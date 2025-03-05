<?php

namespace App\Services\Interfaces\Admin;

use App\Models\ReportType;
use Illuminate\Http\Request;

interface ReportTypeServiceInterface
{
    public function getReportTypes(Request $request);
    public function create(array $data);
    public function update(ReportType $reportType, array $data);
    public function getReportType($id);
}
