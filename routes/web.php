<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\TroubleshootingController;
use App\Http\Controllers\Auth\LoginController; // 👈 importa o controller de login


// =========================
// 🔐 ROTAS DE LOGIN
// =========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');   // exibe o formulário
Route::post('/login', [LoginController::class, 'login']);                        // processa login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');      // logout


// =========================
// ROTAS PROTEGIDAS (só logado)
// =========================
Route::middleware('auth')->group(function () {

    // ao acessar "/", manda pra dashboard (comandos)
    Route::get('/', [CommandController::class, 'index'])->name('comandos');

    Route::get('/troubleshooting', [TroubleshootingController::class, 'page'])->name('troubleshooting');

    // (opcional) se ainda usa páginas separadas:
    Route::view('/novoComando', 'novoComando')->name('novoComando');
    Route::view('/novoTroubleshooting', 'novoTroubleshooting')->name('novoTroubleshooting');

    // POSTs reais
    Route::post('/comandos', [CommandController::class, 'store'])->name('comandos.store');
    Route::post('/troubleshooting', [TroubleshootingController::class, 'store'])->name('troubleshooting.store');

    // Ações
    Route::post('/comandos/{command}/favorite', [CommandController::class,'toggleFavorite'])->name('comandos.favorite');
    Route::post('/comandos/{command}/used', [CommandController::class,'incrementUsage'])->name('comandos.used');

    // Update
    Route::put('/troubleshooting/{troubleshooting}', [TroubleshootingController::class, 'update'])
        ->name('troubleshooting.update');

    // Delete
    Route::delete('/troubleshooting/{troubleshooting}', [TroubleshootingController::class, 'destroy'])
    ->name('troubleshooting.destroy');

    // Pesquisa AJAX
    Route::get('/troubleshooting/search', [\App\Http\Controllers\TroubleshootingController::class, 'search'])
    ->name('troubleshooting.search');

Route::get('/troubleshooting/{id}/edit', [\App\Http\Controllers\TroubleshootingController::class, 'edit'])
    ->name('troubleshooting.edit');


});
