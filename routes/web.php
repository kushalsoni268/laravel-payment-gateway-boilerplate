<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');

/* PayPal Payment Routes */
Route::post('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment-cancel', [PayPalController::class, 'cancel'])->name('paypal.payment.cancel');
Route::get('paypal/payment-success', [PayPalController::class, 'success'])->name('paypal.payment.success');

/* Stripe Payment Routes */
Route::post('stripe/payment', [StripeController::class, 'payment'])->name('stripe.payment');
Route::post('change-payment-status', [StripeController::class, 'changePaymentStatus'])->name('change.payment.status');

/* Stripe Payment Using Laravel Cashier */
Route::get('cashier-checkout', [HomeController::class, 'cashierCheckout'])->name('cashier.checkout');
Route::post('stripe/cashier-payment', [StripeController::class, 'cashierPayment'])->name('stripe.cashier.payment');

/* Product */
Route::resource('products', ProductController::class);
Route::post('getproducts',[ProductController::class, 'postProductList'])->name('getproducts');

/* Stripe Transactions */
Route::get('stripe-transaction', [TransactionController::class, 'stripeTransaction'])->name('stripe-transaction');
Route::post('getstripetransactions',[TransactionController::class, 'postStripeTransactionList'])->name('getstripetransactions');
Route::post('getstripecashiertransactions',[TransactionController::class, 'postStripeCashierTransactionList'])->name('getstripecashiertransactions');
Route::get('stripe-refund/{id}', [TransactionController::class, 'getStripeRefund'])->name('striperefund');
Route::get('stripe-cashier-refund/{id}', [TransactionController::class, 'getStripeCashierRefund'])->name('stripecashierrefund');
Route::post('stripe-refund', [TransactionController::class, 'postStripeRefund'])->name('post.stripe.refund');
Route::post('stripe-cashier-refund', [TransactionController::class, 'postStripeCashierRefund'])->name('post.stripe.cashier.refund');

/* Paypal Transactions */
Route::get('paypal-transaction', [TransactionController::class, 'paypalTransaction'])->name('paypal-transaction');
Route::post('getpaypaltransactions',[TransactionController::class, 'postPaypalTransactionList'])->name('getpaypaltransactions');
Route::get('paypal-refund/{id}', [TransactionController::class, 'getPaypalRefund'])->name('paypalrefund');
Route::post('paypal-refund', [TransactionController::class, 'postStripePaypalRefund'])->name('post.paypal.refund');