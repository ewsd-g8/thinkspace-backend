<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Report;
use Illuminate\Http\Request;

interface ReportServiceInterface
{
    public function getReports(Request $request);
    public function create(array $data);
    public function getReport($id);
    public function changeStatus(Report $report);
}
