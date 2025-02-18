<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'category_idea', 'category_id', 'idea_id');
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['name', 'description', 'is_active'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'name';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $sql = "(CASE WHEN categories.is_active = 1 THEN 'Active' ELSE 'Inactive' END)  like ?";
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereRaw($sql, ["%{$search}%"]);
        }
    }
}
