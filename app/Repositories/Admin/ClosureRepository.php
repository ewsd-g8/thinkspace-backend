<?php

namespace App\Repositories\Admin;

use App\Models\Closure;

class ClosureRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Closure::class;
    }

    public function getClosures($request)
    {
        $closures = Closure::select('id', 'name', 'date', 'final_date', 'created_at', 'updated_at')->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $closures = $closures->paginate(request()->get('paginate'));
        } else {
            $closures = $closures->paginate(10);
        }

        return $closures;
    }

    public function create(array $data): Closure
    {
        $closure = Closure::create([
            'name'  => $data['name'],
            'date' => $data['date'],
            'final_date' => $data['final_date'],
        ]);

        return $closure;
    }

    public function getClosure($id)
    {
        return Closure::where('id', $id)->first();
    }

    public function update(Closure $closure, array $data): Closure
    {
        $closure->name = isset($data['name']) ? $data['name'] : $closure->name;
        $closure->date = isset($data['date']) ? $data['date'] : $closure->date;
        $closure->final_date = isset($data['final_date']) ? $data['final_date'] : $closure->final_date;

        if ($closure->isDirty()) {
            $closure->save();
        }

        return $closure;
    }

    public function changeStatus(Closure $closure)
    {
        $newStatus = $closure->is_active == 1 ? 0 : 1;

        $closure->update([
            'is_active' => $newStatus,
            'updated_at' => now(),
        ]);

        return $closure->refresh();
    }
}
