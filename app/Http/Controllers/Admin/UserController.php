<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Admin\User\UserResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('user-list'), only:['index']),
            new Middleware(PermissionMiddleware::using('user-create'), only:['store']),
            new Middleware(PermissionMiddleware::using('user-edit'), only:['update', 'changeStatus','changeBlockStatus','changeHiddenStatus']),
            new Middleware(PermissionMiddleware::using('dashboard-view'), only:['mostActiveUsers', 'getBrowsers']),
        ];
    }
    
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);

        return response()->success('Success!', Response::HTTP_OK, $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->userService->getUserById($id);
        $result = new UserResource($data);

        return response()->success('Success!', Response::HTTP_OK, $result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function changeStatus(User $user)
    {
        $changedStatus = $this->userService->changeStatus($user);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }

    public function changeBlockStatus(User $user)
    {
        $this->userService->changeBlockStatus($user);

        return response()->success('Success!', Response::HTTP_OK);
    }
    public function changeHiddenStatus(User $user)
    {
        $this->userService->changeHiddenStatus($user);
        
        return response()->success('Success!', Response::HTTP_OK);
    }

    public function getRoles()
    {
        $data = $this->userService->getRoles();

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    public function getDepartments()
    {
        $data = $this->userService->getDepartments();

        return response()->success('Success', Response::HTTP_OK, $data);
    }

    public function getBrowsers()
    {
        $totalUsers = DB::table('browser_user')->count(); // Total users who have browsers

        return Browser::select('id', 'name', 'color')->withCount('users')
            ->get()
            ->map(function ($browser) use ($totalUsers) {
                $browser->usage_percentage = $totalUsers > 0
                    ? round(($browser->users_count / $totalUsers) * 100, 2)
                    : 0;
                return $browser;
            });
    }

    public function mostActiveUsers()
    {
        $users = User::where('is_active', 1)->with(['department:id,name'])->withCount(['ideas', 'comments'])->orderByRaw('(ideas_count + (comments_count / 4)) DESC');

        if (request()->has('paginate')) {
            $users = $users->paginate(request()->get('paginate'));
        } else {
            $users = $users->paginate(5);
        }
        
        return $users;
    }
}
