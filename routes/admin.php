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
        'categories' => CategoryController::class,
        'closures' => ClosureController::class,
        'departments' => DepartmentController::class,
        'ideas' => IdeaController::class,
        'reports' => ReportController::class,
        'report-types' => ReportTypeController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
        'comments' => CommentController::class,
    ]);
    
    Route::get('users/block-status/{user}', [UserController::class, 'changeBlockStatus']);
    Route::get('users/hide-status/{user}', [UserController::class, 'changeHiddenStatus']);

    Route::post('reactions', [ReactionController::class, 'store']);

    Route::post('views', [ViewController::class, 'store']);
    Route::get('views/get-users-view-idea/{idea}', [ViewController::class,'getUsersViewByIdea']);

    Route::get('categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
    Route::get('closures/change-status/{closure}', [ClosureController::class, 'changeStatus']);
    Route::get('departments/change-status/{department}', [DepartmentController::class, 'changeStatus']);
    Route::get('ideas/change-status/{idea}', [IdeaController::class, 'changeStatus']);
    Route::get('reports/change-status/{report}', [ReportController::class, 'changeStatus']);
    Route::get('report-types/change-status/{reportType}', [ReportTypeController::class, 'changeStatus']);
    Route::get('users/change-status/{user}', [UserController::class, 'changeStatus']);

    Route::get('auth-user', [AuthController::class, 'getAuthUser']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
    Route::get('/get-all-roles', [UserController::class, 'getRoles']);
    Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
    Route::get('/get-all-departments', [UserController::class, 'getDepartments']);
    Route::get('/get-all-report-types', [ReportTypeController::class, 'getAllReportTypes']);

    Route::get('export-ideas/{closure_id}', [IdeaController::class, 'export']);
    Route::get('download-documents/{closure_id}', [IdeaController::class, 'downloadDocuments']);

    // Statistic Routes
    Route::get('/stats/ideas-per-department', [DepartmentController::class,'ideasPerDepartment']);
});




//dummy api for dropzone
Route::get('/dummy-data', function () {
    return 'dummy';
});
