<?php
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('tickets.index'));
Route::resource('tickets', TicketController::class)->only(['index','create','store']);
