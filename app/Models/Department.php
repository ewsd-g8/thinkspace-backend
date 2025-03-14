<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, Uuids;

    protected $guarded=[];

    protected $fillable = ['name', 'description'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function ideas(){
        return $this->hasManyThrough(Idea::class, User::class);
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['name','description'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'name';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
    }
}
