<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// route::resource('customers', CustomerController::class);
// route::resource('invoices', InvoiceController::class);
// route::resource('invoiceitems', InvoiceItemController::class);
// route::resource('products', ProductController::class);
// route::resource('counters', CounterController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Invoices
 */
Route::get('get_all_invoices', [InvoiceController::class, 'index']);
Route::get('search_invoice', [InvoiceController::class, 'search']);
Route::get('create_invoice', [InvoiceController::class, 'create']);
Route::post('add_invoice', [InvoiceController::class, 'store']);

/**
 * Customers
 */
Route::get('customers', [CustomerController::class, 'index']);

/**
 * Products
 */
Route::get('products', [ProductController::class, 'index']);
