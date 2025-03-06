<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Models\Closure;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idea extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_idea', 'idea_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function closure()
    {
        return $this->belongsTo(Closure::class); // Ensure correct foreign key
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // public function getHasReactedAttribute()
    // {
    //     return $this->reactions()->where('user_id', auth()->id())->exists();
    // }

    // get the user's reaction type / status for an idea
    public function getUserReactionType()
    {
        $reaction = $this->reactions()->where('user_id', auth()->id())->first();
        return $reaction ? ($reaction->type ? true : false) : 'has not reacted';
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['title', 'content'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'title';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%")
                  ->orWhereHas('categories', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        }
    }
    public function scopeFilterByCategories($query, $categoryIds)
    {
        if (!empty($categoryIds)) {
            return $query->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }
        return $query;
    }
    public function scopeFilterByDepartments($query, $departmentIds)
    {
        if (!empty($departmentIds)) {
            return $query->whereHas('user', function ($query) use ($departmentIds) {
                $query->whereIn('department_id', $departmentIds);
            });
        }
        return $query;
    }

    public function scopeFilterByClosures($query, $closureIds)
    {
        if (!empty($closureIds)) {
            return $query->whereIn('closure_id', $closureIds);
        }
        return $query;
    }
}
