<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'show']);

Route::post('/', [ProductController::class, 'create']);

Route::get('/edit/{id}', [ProductController::class, 'edit']);

Route::put('/update/{id}', [ProductController::class, 'update']);
