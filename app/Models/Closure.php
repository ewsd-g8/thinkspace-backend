<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closure extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function ideas()
    {
        return $this->belongsTo(Idea::class);
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['name', 'date', 'final_date'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'name';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('date', 'like', "%$search%")
                  ->orWhere('final_date', 'like', "%$search%");
        }
    }
}
