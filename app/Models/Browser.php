<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Browser extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'browser_user', 'browser_id', 'user_id');
    }
}
