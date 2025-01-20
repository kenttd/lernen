<?php

use Amentotech\LaraPayEase\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'],function (){
    /**
     *  STRIPE PAYMENT ROUTE
     * */
    Route::post('payease/stripe',[StripePaymentController::class,'prepareCharge'])->name('payease.stripe');
});
