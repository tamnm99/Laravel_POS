<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/shop', [ShopController::class, 'login'])->name('shop');
