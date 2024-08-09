<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ConceptController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\PlanController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/sign-up', [AuthController::class, 'signUp']);
    Route::post('/sign-in', [AuthController::class, 'signIn']);
    Route::post('/sign-out', [AuthController::class, 'signOut'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('members', MemberController::class)->except('create', 'edit');
    Route::resource('plans', PlanController::class)->except('create', 'edit');
    Route::resource('subscriptions', SubscriptionController::class)->except('create', 'edit');
    Route::resource('categories', CategoryController::class)->except('create', 'edit');
    Route::resource('products', ProductController::class)->except('create', 'edit');
    Route::resource('sales', SaleController::class)->except('create', 'edit');
    Route::resource('concepts', ConceptController::class)->except('create', 'edit');
});
