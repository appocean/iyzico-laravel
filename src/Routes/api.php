<?php

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

Route::middleware('auth:api')->name('api::')->prefix('payments')->group(function () {
    Route::post('/token', 'PaymentApiController@token');
    Route::post('/check/user/can/pay', 'PaymentApiController@checkUserCanPay');
    Route::apiResource('/products', ProductApiController::class);
    Route::apiResource('/plans', PlanApiController::class);
    Route::apiResource('/plans/{plan_id}/features', PlanFeatureApiController::class);
    Route::apiResource('/plans/{plan_id}/subscriptions', PlanSubscriptionApiController::class);
    Route::post('/plans/{plan_id}/subscriptions/without/provider', 'PlanSubscriptionApiController@subscriptionWithoutPaymentProvider');
    Route::post('/plans/{plan_id}/subscriptions/{subscription_id}/change', 'PlanSubscriptionApiController@changePlan');
    Route::get('/subscriptions/check/by/ended/trial', 'PlanSubscriptionApiController@checkByEndedTrial');
    Route::get('/subscriptions/check/by/ended/period', 'PlanSubscriptionApiController@checkByEndedPeriod');
    Route::get('/subscriptions', 'PlanSubscriptionApiController@subscriptions');
    Route::post('/plans/subscriptions', 'PlanSubscriptionApiController@cancel');
});
