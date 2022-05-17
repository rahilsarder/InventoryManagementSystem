<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\RolesNPermissions\AssignPermissionsToRoles;
use App\Http\Controllers\RolesNPermissions\AssignUserRoles;
use App\Http\Controllers\RolesNPermissions\RolesController;
use App\Http\Controllers\RolesNPermissions\PermissionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// xxxxxxxxxxxxxxxxxxx      Roles & Permissions     xxxxxxxxxxxxxxxxxxxx

Route::apiResource('permissions', PermissionsController::class);
Route::apiResource('roles', RolesController::class);
Route::apiResource('user/roles', AssignUserRoles::class);
Route::apiResource('roles/assign', AssignPermissionsToRoles::class);

// xxxxxxxxxxxxxxxxxxx      Authentication     xxxxxxxxxxxxxxxxxxxx

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);
});

// xxxxxxxxxxxxxxxxxxx      Inventory CRUD     xxxxxxxxxxxxxxxxxxxx

Route::middleware('auth:api')->group(function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('stocks', StockController::class)->middleware('role_or_permission:Super Admin|Write');
});
