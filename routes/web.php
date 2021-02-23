<?php

use App\Http\Controllers\Account;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBot;
use App\Http\Controllers\Login;
use App\Http\Controllers\Signin;
use App\Http\Controllers\Transactions\Deposit;
use App\Http\Controllers\Transactions\Withdraw;
use App\Http\Controllers\Utilities\Converter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');
Route::prefix('chatbot')->name('chatbot.')->group(function () {
    Route::get('welcome', [ChatBot::class, 'welcome'])->name('welcome');
    Route::post('message', [ChatBot::class, 'message'])->name('message');
});
Route::prefix('login')->name('login.')->group(function () {
    Route::get('/', [Login::class, 'init'])->name('init');
    Route::prefix('check')->name('check.')->group(function () {
        Route::get('user', [Login::class, 'checkUser'])->name('user');
        Route::get('password', [Login::class, 'checkPassword'])->name('password');
    });
});
Route::prefix('signin')->name('signin.')->group(function () {
    Route::get('/', [Signin::class, 'init'])->name('init');
    Route::prefix('check')->name('check.')->group(function () {
        Route::get('user', [Signin::class, 'checkUser'])->name('user');
        Route::get('password', [Signin::class, 'checkPassword'])->name('password');
        Route::get('confirmation', [Signin::class, 'checkConfirmation'])->name('confirmation');
    });
    Route::get('set/currency', [Signin::class, 'setCurrency'])->name('set.currency');
});
Route::prefix('account')->name('account.')->middleware('userinsession')->group(function () {
    Route::get('/', [Account::class, 'init'])->name('init');
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::prefix('deposit')->name('deposit.')->group(function () {
            Route::get('/', [Deposit::class, 'init'])->name('init');
            Route::get('check/amount', [Deposit::class, 'checkAmount'])->name('check.amount');
        });
        Route::prefix('withdraw')->name('withdraw.')->group(function () {
            Route::get('/', [Withdraw::class, 'init'])->name('init');
            Route::get('check/amount', [Withdraw::class, 'checkAmount'])->name('check.amount');
        });
    });
    Route::get('balance', [Account::class, 'balance'])->name('balance');
    Route::prefix('currency')->name('currency.')->group(function () {
        Route::get('/', [Account::class, 'selectCurrency'])->name('select');
        Route::get('update', [Account::class, 'updateCurrency'])->name('update');
    });
    Route::prefix('utilities')->name('utilities')->group(function () {
        Route::prefix('converter')->name('converter.')->group(function () {
            Route::get('/', [Converter::class, 'init'])->name('init');
            Route::get('convert', [Converter::class, 'convert'])->name('convert');
        });
    });
    Route::get('logout', [Account::class, 'logout'])->name('logout');
});
