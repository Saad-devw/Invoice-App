<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

// route::resource('customers', CustomerController::class);
// route::resource('invoices', InvoiceController::class);
// route::resource('invoiceitems', InvoiceItemController::class);
// route::resource('products', ProductController::class);
// route::resource('counters', CounterController::class);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/{pathMatch}', function(){
    return view('welcome');
})->where('pathMatch',".*");