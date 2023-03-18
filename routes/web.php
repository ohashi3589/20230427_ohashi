<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstController;

Route::get('/building', [FirstController::class, 'building']);
Route::get('/building/{msg?}',[FirstController::class, 'room']);