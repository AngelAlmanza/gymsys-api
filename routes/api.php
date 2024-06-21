<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SubscriptionController;
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
