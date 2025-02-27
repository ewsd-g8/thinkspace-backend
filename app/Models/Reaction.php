<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory, Uuids;
    protected $fillable = [
        'type',
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
}
