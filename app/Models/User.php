<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuids;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, Uuids;
    
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'profile',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeAdminSort($query, $sortType, $sortBy)
    {
        $sortFields = ['name', 'email','mobile', 'is_active'] ;

        if ($sortBy && $sortType) {
            $sortField = in_array($sortBy, $sortFields) ? $sortBy : 'name';
            $query->orderBy($sortField, $sortType);
        }
    }

    public function scopeAdminSearch($query, $search)
    {
        if (!is_null($search)) {
            $sql = "(CASE WHEN users.is_active = 1 THEN 'Active' ELSE 'Inactive' END)  like ?";
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('mobile', 'like', "%$search%")
                  ->orWhereHas('roles', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  })
                  ->orWhereRaw($sql, ["%{$search}%"]);
        }
    }
}
