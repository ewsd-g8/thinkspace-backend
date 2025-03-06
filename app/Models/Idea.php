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

    public function scopeFilterHiddenUser($query)
    {
        $query->whereHas('user', function ($q) {
            $q->where('is_hidden', false);
        });
    }

    public function scopeFilterByCategory($query, $category)
    {
        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }
    }

    public function scopeFilterByDepartment($query, $department)
    {
        if ($department) {
            $query->whereHas('user', function ($q) use ($department) {
                $q->whereHas('department', function ($d) use ($department) {
                    $d->where('name', $department);
                });
            });
        }
    }

    public function scopeFilterByClosure($query, $closure)
    {
        if ($closure) {
            $query->whereHas('closure', function ($q) use ($closure) {
                $q->where('name', $closure);
            });
        }
    }

    public function scopeFilterByContentLength($query, $contentLength)
    {
        if ($contentLength) {
            if ($contentLength === 'short') {
                $query->whereRaw('LENGTH(content) < 100');
            } elseif ($contentLength === 'medium') {
                $query->whereRaw('LENGTH(content) >= 100 AND LENGTH(content) <= 400');
            } elseif ($contentLength === 'long') {
                $query->whereRaw('LENGTH(content) > 400');
            }
        }
    }

    public function scopeCustomSort($query, $sort)
    {
        if ($sort) {
            switch ($sort) {
                case 'newest':
                    $query->latest('created_at');
                    break;
                case 'oldest':
                    $query->oldest('created_at');
                    break;
                case 'mostLikes':
                    $query->orderBy('likes', 'desc');
                    break;
                case 'mostDislikes':
                    $query->orderBy('unlikes', 'desc');
                    break;
                default:
                    $query->latest('created_at');
            }
        } else {
            $query->latest('created_at');
        }
    }
}
