<?php

use App\Http\Controllers\SoapController;

Route::post('/client-register', [SoapController::class, 'registerClient']);
Route::post('/recharge-wallet', [SoapController::class, 'rechargeWallet']);
Route::post('/pay', [SoapController::class, 'pay']);
Route::post('/confirm-pay', [SoapController::class, 'confirmPayment']);
Route::get('/check-balance', [SoapController::class, 'checkBalance']);

