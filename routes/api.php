<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankChangeRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/roles', function () {
    return Role::select('id', 'name')->get();
})->name('api.roles');

Route::middleware(['auth:sanctum'])->group(function () {
    // Add Middleware Only Employee can access this api
    Route::middleware(['role:Employee'])->group(function () {
        Route::get('/bank/details', [BankAccountController::class, 'getBankDetails'])
            ->name('bank-account.detail');
        Route::post('/bank/create', [BankAccountController::class, 'store'])
            ->name('bank-account.store');
        Route::post('/bank/change-request', [BankChangeRequestController::class, 'store'])
            ->name('bank-account.change-request');
        Route::get('/bank/my-requests', [BankChangeRequestController::class, 'myRequests'])
            ->name('bank-account.my-change-request');
    });
    
    // Add Middleware Only HR can access this api
    Route::middleware(['role:HR'])->group(function () {
        Route::get('/bank/change-requests', [BankChangeRequestController::class, 'index'])
            ->name('bank-account.change-requests');
        Route::post('/bank/approved/{bankChangeRequest}', [BankChangeRequestController::class, 'update'])
            ->name('bank-account.change-request-approved');
        Route::post('/bank/rejected/{bankChangeRequest}', [BankChangeRequestController::class, 'update'])
            ->name('bank-account.change-request-rejected'); 
    });
});