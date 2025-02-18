<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_idea', 'idea_id', 'category_id');
    }

    public function closure()
    {
        return $this->hasOne(Closure::class);
    }
}
