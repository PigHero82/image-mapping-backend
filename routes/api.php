<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DropdownController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\Master\{
    UserController,
    ProductController
};
use App\Http\Controllers\Api\Master\Mapping\{
    MappingController,
    DetailMappingController
};

/*
|-------------------------------------------------------------a-------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('unauthorized', 'unauthorized')->name('unauthorized');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dropdown
    Route::prefix('dropdown')->group(function () {
        Route::get('detail-mapping', [DropdownController::class, 'detail_mapping']);
        Route::get('mapping-action', [DropdownController::class, 'mapping_action']);
        Route::get('product', [DropdownController::class, 'product']);
    });

    // Master
    Route::prefix('/master')->group(function () {
        // User
        Route::controller(UserController::class)->prefix('/user')->group(function() {
            Route::get('role-list', 'roleList');
        });

        // Resources
        Route::apiResources([
            'user'              => UserController::class,
            'product'           => ProductController::class,

            // Mapping
            'mapping'           => MappingController::class,
            'detail-mapping'    => DetailMappingController::class,
        ]);

        // Detail Mapping
        Route::post('detail-mapping/detail/{detailMapping}', [DetailMappingController::class, 'store_detail']);
        Route::patch('detail-mapping/update-default/{detailMapping}', [DetailMappingController::class, 'update_default']);
    });

    Route::prefix('/file')->group(function () {
        Route::post('/', [FileController::class, 'store']);
        Route::post('/destroy', [FileController::class, 'destroy']);
    });
});