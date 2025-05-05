<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'reason',
        'is_active',
        'idea_id',
        'user_id',
        'report_type_id'
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['reason', 'is_active'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'reason';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $sql = "(CASE WHEN reports.is_active = 1 THEN 'Active' ELSE 'Inactive' END)  like ?";
            $query->where('reason', 'like', "%$search%")
                  ->orWhereRaw($sql, ["%{$search}%"]);
        }
    }
}
