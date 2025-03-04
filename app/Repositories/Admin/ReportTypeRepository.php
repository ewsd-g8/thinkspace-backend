<?php

namespace App\Repositories\Admin;

use App\Models\ReportType;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class ReportTypeRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return ReportType::class;
    }

    public function getReportTypes($request)
    {
        $reportTypes = ReportType::select('id', 'name', 'description', 'created_at', 'updated_at')->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $reportTypes = $reportTypes->paginate(request()->get('paginate'));
        } else {
            $reportTypes = $reportTypes->paginate(10);
        }

        return $reportTypes;
    }

    public function create(array $data): ReportType
    {
        $reportType = ReportType::create([
            'name'  => $data['name'],
            'description' => $data['description'],
        ]);

        return $reportType;
    }

    public function getReportType($id)
    {
        return ReportType::where('id', $id)->first();
    }

    public function update(ReportType $reportType, array $data): ReportType
    {
        $reportType->name = isset($data['name']) ? $data['name'] : $reportType->name;
        $reportType->description = isset($data['description']) ? $data['description'] : $reportType->description;
        
        if ($reportType->isDirty()) {
            $reportType->save();
        }

        return $reportType;
    }
}
