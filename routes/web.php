<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Party\PartyController;
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

        // terminal route start
        Route::prefix('terminal')->group(function () {
            Route::get('/index', [TerminalController::class, 'index'])->name('terminal.index');
            Route::get('/create', [TerminalController::class, 'create'])->name('terminal.create');
            Route::post('/create', [TerminalController::class, 'store'])->name('terminal.store');
            Route::get('/datatable', [TerminalController::class, 'datatable'])->name('terminal.datatable');
        });
        // terminal route end

        // party route start
        Route::prefix('party')->group(function () {
            Route::get('/index', [PartyController::class, 'index'])->name('party.index');
            Route::get('/create', [PartyController::class, 'create'])->name('party.create');
            Route::post('/store', [PartyController::class, 'store'])->name('party.store');
            // Route::get('/{party}', [PartyController::class, 'show'])->name('party.show');
            Route::get('/{party}/edit', [PartyController::class, 'edit'])->name('party.edit');
            Route::put('/{party}/update', [PartyController::class, 'update'])->name('party.update');
            Route::delete('/{party}', [PartyController::class, 'destroy'])->name('party.destroy');
            Route::post('/status/update', [PartyController::class, 'statusUpdate'])->name('party.status.update');
            Route::put('/status/{party}', [PartyController::class, 'getStatusByUid'])->name('party.status');
        
            // datatable
            Route::get('/datatable', [PartyController::class, 'datatable'])->name('party.datatable');
        });
        // party route end

        // content manegment route start
        Route::prefix('system-content')->group(function () {
            Route::get('/', [SystemController::class, 'index'])->name('system');
            Route::post('/systempost', [SystemController::class, 'systemPost'])->name('system.post');
            Route::get('/system-database', [SystemController::class, 'systemDatabase'])->name('system.database');
        });
        
    });
});
