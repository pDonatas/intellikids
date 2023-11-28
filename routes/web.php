<?php

declare(strict_types=1);

use App\Http\Controllers\Routing\RoutingController;
use Illuminate\Support\Facades\Route;

Route::get('/{url:short_url}', RoutingController::class)->name('router');
