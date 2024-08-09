<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AppController;

Route::get('/', [AppController::class, 'index']);
