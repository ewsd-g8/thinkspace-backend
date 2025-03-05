<?php

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
    ]);
    Route::get('users/change-status/{user}', [UserController::class, 'changeStatus']);
    Route::get('users/block-status/{user}', [UserController::class, 'changeBlockStatus']);
    Route::get('users/hide-status/{user}', [UserController::class, 'changeHiddenStatus']);    

    Route::get('categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
    Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
    Route::get('ideas/increase-views/{idea}', [IdeaController::class, 'increaseViews']);

    Route::post('reactions', [ReactionController::class, 'store']);
    Route::get('ideas/{idea}/count-reactions', [ReactionController::class, 'getIdeaReactionCount']);
    Route::get('ideas/{idea}/reactions/me', [ReactionController::class, 'getUserReactionForIdea']);

    Route::get('auth-user', [AuthController::class, 'getAuthUser']);
    Route::get('/get-all-roles', [UserController::class, 'getRoles']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
    Route::get('/get-all-departments', [UserController::class, 'getDepartments']);

});

//dummy api for dropzone
Route::get('/dummy-data', function () {
    return 'dummy';
});
