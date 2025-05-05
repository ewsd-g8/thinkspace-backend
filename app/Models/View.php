<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model
{
    use HasFactory, Uuids;

    protected $fillable =[
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
