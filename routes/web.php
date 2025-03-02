<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\TerminalController;
use Illuminate\Support\Facades\Route;

//
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'loginPost']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::get('/create-admin', [AdminController::class, 'index'])->name('admin.index');

        Route::prefix('agent')->group(function () {
            Route::get('/index', [AgentController::class, 'index'])->name('agent.index');
            Route::get('/create', [AgentController::class, 'create'])->name('agent.create');
            Route::post('/store', [AgentController::class, 'store'])->name('agent.store');
            // Route::get('/{agent}', [AgentController::class, 'show'])->name('agent.show');
            Route::get('/{agent}/edit', [AgentController::class, 'edit'])->name('agent.edit');
            Route::PUT('/{agent}/update', [AgentController::class, 'update'])->name('agent.update');
            Route::put('/{agent}', [AgentController::class, 'update'])->name('agent.update');
            Route::delete('/{agent}', [AgentController::class, 'destroy'])->name('agent.destroy');
            Route::post('/status/update', [AgentController::class, 'statusUpdate'])->name('agent.status.update');
            Route::put('/status/{agent}', [AgentController::class, 'getStatusByUid'])->name('agent.status');
            Route::post('/get/districts', [AgentController::class, 'getdistricts'])->name('get.districts');
            Route::post('/get/thanas', [AgentController::class, 'getThanas'])->name('get.thanas');

            // datatable
            Route::get('/datatable', [AgentController::class, 'datatable'])->name('agent.datatable');
        });
        Route::prefix('terminal')->group(function () {
            Route::get('/index', [TerminalController::class, 'index'])->name('terminal.index');
            Route::get('/create', [TerminalController::class, 'create'])->name('terminal.create');
            Route::post('/create', [TerminalController::class, 'store'])->name('terminal.store');
            Route::get('/datatable', [TerminalController::class, 'datatable'])->name('terminal.datatable');
        });
    });
});
