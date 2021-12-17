<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\postControllerCustomer;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        /** Add a new customer  */
        Route::post('v1/addCustomer',function (Request $request) {
            $createCustomer = new postControllerCustomer();
            return $createCustomer->store($request);
        });

        /** Show a costumer*/
        Route::post('v1/showCustomer',function (Request $request) {
            $createCustomer = new postControllerCustomer();
            return $createCustomer->showCustomer($request);
        });

        /** Delete a customer */
        Route::post('v1/deleteCustomer',function (Request $request) {
            $createCustomer = new postControllerCustomer();
            return $createCustomer->deleteCustomer($request);
        });

    });
});


