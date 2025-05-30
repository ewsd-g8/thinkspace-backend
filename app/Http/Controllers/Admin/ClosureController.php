<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Closure\CreateClosureRequest;
use App\Http\Requests\Admin\Closure\UpdateClosureRequest;
use App\Models\Closure;
use App\Services\Admin\ClosureService;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ClosureController extends Controller implements HasMiddleware
{
    
    protected $closureService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:closure-list', only: ['index', 'show']),
            new Middleware('permission:closure-create', only: ['store']),
            new Middleware('permission:closure-edit', only: ['update', 'changeStatus'])
        ];

    }

    public function __construct(ClosureService $closureService)
    {
        $this->closureService = $closureService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $closures = $this->closureService->getClosures($request);

        return response()->success('Success!', Response::HTTP_OK, $closures);
    }
            
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClosureRequest $request)
    {
        $this->closureService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->closureService->getClosure($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClosureRequest $request, ClosureModel $closure)
    {
        $this->closureService->update($closure, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Closure $closure)
    {
        $changedStatus = $this->closureService->changeStatus($closure);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }

    public function getAllClosures()
    {
        $data = $this->closureService->getAllClosures();

        return response()->success('Success', Response::HTTP_OK, $data); 
    }

    public function getClosurePostStatus()
    {
        $result = [
            "post" => false,
            "comment" => false
        ];

        $activeClosure = Closure::where("is_active", true)->first();

        if (!$activeClosure) {
            return response()->success('Success', Response::HTTP_OK, $result);
        }

        $date = new \DateTime($activeClosure->date);
        $finalDate = new \DateTime($activeClosure->final_date);
        $now = now();
        
        if ($now < $date) {
            $result["post"] = true;
            $result["comment"] = true;
        } 
        elseif ($now >= $date && $now <= $finalDate) {
            $result["post"] = false;
            $result["comment"] = true;
        } 
        elseif ($now > $finalDate) {
            $result["post"] = false;
            $result["comment"] = false;
        }

        return response()->success('Success', Response::HTTP_OK, $result);
    }
}
