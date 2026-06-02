<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

Route::get('/', [CryptoController::class, 'index']);

Route::get('/cryptocurrencies', [
    CryptoController::class,
    'getCryptocurrencies'
]);

Route::get('/sync-crypto', [
    CryptoController::class,
    'sync'
]);