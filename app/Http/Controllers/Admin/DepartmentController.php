<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Idea;
use App\Services\Admin\DepartmentService;
use App\Http\Resources\Department\DepartmentResource;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\Department\CreateDepartmentRequest;
use App\Http\Requests\Admin\Department\UpdateDepartmentRequest;


class DepartmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:department-list', only:['index','show','ideasPerDepartment','userContributionsPerDepartment']),
            new Middleware('permission:department-create', only: ['store']),
            new Middleware('permission:department-edit', only: ['update', 'changeStatus']),
            new Middleware('permission:department-delete', only: ['destroy'])
        ];
    }

    /**
     * @var DepartmentService
     */
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $departments = $this->departmentService->getDepartments($request);

        return response()->success('Success!', Response::HTTP_OK, $departments);
    }

    // public function index()
    // {
    //     $departments = Department::all();
    //     return response()->json($departments);
    // }

    public function store(CreateDepartmentRequest $request)
    {
        $this->departmentService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:100',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Name should not exceed 100 characters'
    //         ], 400);
    //     }
    //     $department = new Department();
    //     $department->name = $request->name;
    //     $department->description = $request->description;
    //     $department->save();
    //     return response()->json([
    //         'message' => 'Department Added!'
    //     ], 201);
    // }
    public function show(string $id)
    {
        $data = $this->departmentService->getDepartmentById($id);
        $result = new DepartmentResource($data);

        return response()->success('Success!', Response::HTTP_OK, $result);
    }
    // public function show($id)
    // {
    //     $department = Department::find($id);
    //     if (!empty($department)) {
    //         return response()->json($department);
    //     } else {
    //         return response()->json([
    //             'message' => 'Department not found'
    //         ], 404);
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:100',
            
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Name should not exceed 100 characters'
    //         ], 400);
    //     }
    //     $department = Department::find($id);
    //     if (!empty($department)) {
    //         $department->name = $request->name;
    //         $department->description = $request->description;
    //         $department->save();
    //         return response()->json([
    //             'message' =>'Department Updated!'
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Department not found'
    //         ], 404);
    //     }
    // }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->departmentService->update($department, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        if (!empty($department)) {
            $department->delete();
            return response()->json([
                'message' => 'Department Deleted!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Department not found'
            ], 404);
        }
    }

    public function changeStatus(Department $department)
    {
        $changedStatus = $this->departmentService->changeStatus($department);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }
    
    public function ideasPerDepartment(){
        // Get total number of ideas
        $totalIdeas = Idea::count();

        // Get departments with their idea counts
        $departments = Department::withCount('ideas')->get();

        // Format the response with percentages
        $stats = $departments->map(function ($department) use ($totalIdeas) {
            $ideasCount = $department->ideas_count;
            $percentage = $totalIdeas > 0 ? round(($ideasCount / $totalIdeas) * 100, 2) : 0;

            return [
                'department_name' => $department->name,
                'ideas_count' => $ideasCount,
                'percentage' => $percentage,
            ];
        });

        return response()->json([
            'total_ideas' => $totalIdeas,
            'departments' => $stats,
        ]);
    }

    public function userContributionsPerDepartment(){
        $departments = Department::with(['users' => function($query){
            $query->withCount(['ideas', 'comments']);
        }])->get();

        $stats = $departments->map(function ($department){
            return [
                'department_name' => $department->name,
                'users' => $department->users->map(function ($user){
                    return [
                        'user_name' => $user->name,
                        'ideas_count' => $user->ideas_count,
                        'comments_count' => $user->comments_count,
                    ];
                })->all(),
            ];
        })->filter(function ($department) {
            return !empty($department['users']); // Only include departments with contributing users
        })->values();

        return response()->json($stats);
    }
}
