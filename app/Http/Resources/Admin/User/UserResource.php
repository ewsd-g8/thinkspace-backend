<?php

namespace App\Http\Resources\Admin\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            // 'profile'=>$this->profile ? Storage::disk('s3')->url($this->profile) : null,
            'profile'=>$this->profile ? $this->profile : null,
            'is_active' => $this->is_active,
            'roles' => $this->roles,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i A'),
            'department_id' => $this->department_id
        ];
    }
}
