<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\TroubleshootingController;

// Páginas
Route::get('/', [CommandController::class, 'index'])->name('comandos');
Route::get('/troubleshooting', [TroubleshootingController::class, 'page'])->name('troubleshooting');

// Páginas estáticas (se usar)
Route::view('/novoComando', 'novoComando')->name('novoComando');
Route::view('/novoTroubleshooting', 'novoTroubleshooting')->name('novoTroubleshooting');

// Ações (SEM auth)
Route::post('/comandos', [CommandController::class, 'store'])->name('comandos.store');
Route::post('/comandos/{command}/favorite', [CommandController::class,'toggleFavorite'])->name('comandos.favorite');
Route::post('/comandos/{command}/used', [CommandController::class,'incrementUsage'])->name('comandos.used');
