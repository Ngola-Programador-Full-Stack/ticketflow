<?php
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('tickets.index'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Tickets (protegidos)
Route::middleware('auth')->group(function () {
    Route::resource('tickets', TicketController::class)->only(['index','create','store']);
    Route::post('/tickets/{ticket}/resolver', [TicketController::class, 'resolver'])->name('tickets.resolver');
});
