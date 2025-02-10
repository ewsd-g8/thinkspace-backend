<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i A', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d h:i A', strtotime($value));
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['name', 'created_at','updated_at'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'name';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('created_at', 'like', "%$search%")
                  ->orWhere('updated_at', 'like', "%$search%");
        }
    }
}
