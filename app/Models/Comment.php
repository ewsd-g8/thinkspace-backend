<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Comment extends Model
{
    use HasFactory, Uuids;
    protected $fillable = [
        'content',
        'user_id',
        'idea_id',
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['content'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'content';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $query->where('content', 'like', "%$search%");
        }
    }
}
