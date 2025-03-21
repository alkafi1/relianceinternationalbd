<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\AgentLoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Bill\BillController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Party\PartyController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\TerminalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'loginPost']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('admin')->group(function () {
            Route::get('/index', [Admincontroller::class, 'index'])->name('admin.index');
            Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
            // Route::get('/{admin}', [AdminController::class, 'show'])->name('admin.show');
            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/{admin}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
            Route::post('/status/update', [AdminController::class, 'statusUpdate'])->name('admin.status.update');
            Route::put('/status/{admin}', [AdminController::class, 'getStatusByUid'])->name('admin.status');

            // datatable
            Route::get('/datatable', [AdminController::class, 'datatable'])->name('admin.datatable');
        });


        Route::prefix('agent')->group(function () {
            Route::get('/index', [AgentController::class, 'index'])->name('agent.index');
            Route::get('/create', [AgentController::class, 'create'])->name('agent.create');
            Route::post('/store', [AgentController::class, 'store'])->name('agent.store');
            // Route::get('/{agent}', [AgentController::class, 'show'])->name('agent.show');
            Route::get('/{agent}/edit', [AgentController::class, 'edit'])->name('agent.edit');
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
            Route::post('/store', [TerminalController::class, 'store'])->name('terminal.store');
            Route::put('/status/{terminal}', [TerminalController::class, 'updateStatus'])->name('terminal.status');
            Route::delete('/{terminal}', [TerminalController::class, 'destroy'])->name('terminal.destroy');

            Route::get('/{terminal}/edit', [TerminalController::class, 'edit'])->name('terminal.edit');
            Route::put('/{terminal}/update', [TerminalController::class, 'update'])->name('terminal.update');

            Route::get('/datatable/terminal', [TerminalController::class, 'datatable'])->name('terminal.datatable');

            // expense
            Route::prefix('expense')->group(function () {
                Route::get('/', [TerminalController::class, 'expenseList'])->name('terminal.expense.index');
                Route::get('/create', [TerminalController::class, 'expenseCreate'])->name('terminal.expense.create');
                Route::post('/store', [TerminalController::class, 'expenseStore'])->name('terminal.expense.store');
                Route::put('/status/{terminalExpense}', [TerminalController::class, 'updateStatusExpense'])->name('terminal.expense.status');
                Route::put('/show/{terminalExpense}', [TerminalController::class, 'show'])->name('terminal.expense.show');
                Route::delete('/{terminalExpense}', [TerminalController::class, 'destroyExpense'])->name('terminal.expense.destroy');
                Route::get('/datatable/terminal', [TerminalController::class, 'datatableTerminalExpense'])->name('terminal.expense.datatable');
            });
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
        Route::prefix('account')->group(function () {
            Route::get('/index', [AccountController::class, 'index'])->name('account.index');
            Route::get('/datatable/account', [AccountController::class, 'datatable'])->name('account.datatable');
        });
        // bill route start

        Route::prefix('bill-register')->group(function () {
            Route::get('/index', [BillController::class, 'index'])->name('bill.register.index');
            Route::get('/datatable/bill-register', [BillController::class, 'datatable'])->name('bill.register.datatable');
        });

        Route::prefix('bill-statement')->group(function () {
            Route::get('/index', [BillController::class, 'index'])->name('bill.statement.index');
        });

        // bill route end

        //system manegment route start
        Route::prefix('system-management')->group(function () {
            Route::get('/', [SystemController::class, 'index'])->name('system.index');
            Route::post('/systempost', [SystemController::class, 'systemPost'])->name('system.post');
        });

        // role route start
        Route::prefix('role')->group(function () {
            Route::get('/index', [RoleController::class, 'index'])->name('role.index');
            Route::get('/create', [RoleController::class, 'create'])->name('role.create');
            Route::post('/store', [RoleController::class, 'store'])->name('role.store');
            Route::post('/delete', [RoleController::class, 'destroy'])->name('role.destroy');

            Route::post('/edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::post('/update', [RoleController::class, 'update'])->name('role.update');

            Route::get('/datatable/role', [RoleController::class, 'datatable'])->name('role.datatable');
        });
        // role route end


    });
});

Route::name('agent.')->prefix('agent')->group(function () {
    Route::get('/', [AgentLoginController::class, 'login'])->name('login');
    Route::post('/', [AgentLoginController::class, 'loginPost']);
    Route::post('/logout', [AgentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth.agent')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'agentIndex'])->name('dashboard');
    });
});
Route::middleware('auth.agent_or_web')->group(function () {
    // job route start
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('job.index');
        Route::get('/create', [JobController::class, 'create'])->name('job.create');
        Route::post('/store', [JobController::class, 'store'])->name('job.store');
        Route::post('/delete', [JobController::class, 'destroy'])->name('job.destroy');

        Route::get('/edit/{job}', [JobController::class, 'edit'])->name('job.edit');
        Route::post('/update/{job}', [JobController::class, 'update'])->name('job.update');

        Route::get('/datatable/job', [JobController::class, 'datatable'])->name('job.datatable');
    });
});
