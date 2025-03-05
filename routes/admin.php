<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClosureController;
use App\Http\Controllers\Admin\IdeaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ReactionController;
use App\Http\Controllers\Admin\ViewController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::apiResources([
        'users' => UserController::class,
        'roles' => RoleController::class,
        'departments' => DepartmentController::class,
        'categories' => CategoryController::class,
        'closures' => ClosureController::class,
        'ideas' => IdeaController::class,
        'comments' => CommentController::class,
        'report-types' => ReportTypeController::class,
        'reports' => ReportController::class,
    ]);
    Route::get('users/change-status/{user}', [UserController::class, 'changeStatus']);
    Route::get('users/block-status/{user}', [UserController::class, 'changeBlockStatus']);
    Route::get('users/hide-status/{user}', [UserController::class, 'changeHiddenStatus']);    

    Route::get('categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
    Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
    Route::get('ideas/increase-views/{idea}', [IdeaController::class, 'increaseViews']);

    Route::post('reactions', [ReactionController::class, 'store']);

    Route::post('views', [ViewController::class, 'store']);
    Route::get('views/get-users-view-idea/{idea}', [ViewController::class,'getUsersViewByIdea']);

    Route::get('auth-user', [AuthController::class, 'getAuthUser']);
    Route::get('/get-all-roles', [UserController::class, 'getRoles']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
    Route::get('/get-all-departments', [UserController::class, 'getDepartments']);
    Route::get('/get-all-report-types', [ReportTypeController::class, 'getAllReportTypes']);

    Route::get('reports/change-status/{report}', [ReportController::class, 'changeStatus']);
});

//dummy api for dropzone
Route::get('/dummy-data', function () {
    return 'dummy';
});
