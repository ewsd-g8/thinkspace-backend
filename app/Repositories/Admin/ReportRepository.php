<?php

namespace App\Repositories\Admin;

use App\Enums\Status;
use App\Models\Report;

class ReportRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Report::class;
    }

    public function getReports($request)
    {
        $reports = Report::with(['idea', 'user:id,full_name,email', 'reportType'])->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $reports = $reports->paginate(request()->get('paginate'));
        } else {
            $reports = $reports->paginate(10);
        }

        return $reports;
    }

    public function create(array $data): Report
    {
        $userId = auth()->user()->id;
        $report = Report::create([
            'reason'  => $data['reason'],
            'is_active' => Status::Active,
            'idea_id' => $data['idea_id'],
            'user_id' => $userId,
            'report_type_id' => $data['report_type_id']
        ]);

        return $report;
    }

    public function getReport($id)
    {
        return Report::where('id', $id)->first();
    }

    public function changeStatus(Report $report)
    {
        if ($report->is_active == 0) {
            $report->update([
                'is_active' => 1,
            ]);

            return $report->refresh();
        } else {
            $report->update([
                'is_active' => 0,
            ]);

            return $report->refresh();
        }
    }
}
