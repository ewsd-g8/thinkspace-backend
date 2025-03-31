<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Closure;
use Illuminate\Http\Request;

interface ClosureServiceInterface
{
    public function getClosures(Request $request);
    public function create(array $data);
    public function update(Closure $closure, array $data);
    public function changeStatus(Closure $closure);
    public function getClosure($id);
    public function getAllClosures();
}
