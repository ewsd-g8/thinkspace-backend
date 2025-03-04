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

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // public function getHasReactedAttribute()
    // {
    //     return $this->reactions()->where('user_id', auth()->id())->exists();
    // }


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
                  ->orWhere('content', 'like', "%$search%");
        }
    }
}
