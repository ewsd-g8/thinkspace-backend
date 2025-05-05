<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Repositories\Admin\IdeaRepository;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IdeasExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $closure_id;

    public function __construct($closure_id)
    {
        $this->closure_id = $closure_id;
    }
    /**
     * Export data to Excel from a view.
     *
     * @implements FromView
     */
    public function view(): View
    {
        $brand_repo = new IdeaRepository();
        $data = $brand_repo->getIdeasByClosure($this->closure_id);
        return view('exports.idea', compact('data'));
    }

    /**
     * Set the title for the exported Excel sheet.
     */
    public function title(): string
    {
        return 'Idea';
    }
}
