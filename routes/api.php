<?php

use Illuminate\Http\Request;

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');
Route::post('verfiy', 'API\UserController@verfiy');
Route::post('resend', 'API\UserController@resend');

// Countries List
Route::get('countries', 'API\CountriesController@index');
Route::get('companies', 'API\CompaniesController@index');
Route::get('usertypes', 'API\UserTypesController@index');
Route::get('companies/{company}', 'API\CompaniesController@show');
Route::get('searchForCompanyID/{company_id}', 'API\CompaniesController@searchForCompanyID');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'API\UserController@details');
    Route::post('edit_profile', 'API\UserController@edit_profile');
    Route::post('changePassword', 'API\UserController@changePassword');
    Route::get('staff_list', 'API\UserController@staff_list');
    Route::post('companies', 'API\CompaniesController@store');
    Route::post('companies/{company}', 'API\CompaniesController@update');
    Route::delete('companies/{company}', 'API\CompaniesController@delete');

    Route::get('categories', 'API\CategoriesController@index');
    Route::get('categories/{category}', 'API\CategoriesController@show');
    Route::post('search_category', 'API\CategoriesController@search');
    Route::post('categories', 'API\CategoriesController@store');
    Route::post('categories/{category}', 'API\CategoriesController@update');
    Route::delete('categories/{category}', 'API\CategoriesController@delete');

    Route::get('items', 'API\ItemsController@index');
    Route::get('items_mostly_orders/{category?}', 'API\ItemsController@mostly_orders');
    Route::get('items_featured_items/{category?}', 'API\ItemsController@featured_items');
    Route::get('items_new_item/{category?}', 'API\ItemsController@new_item');
    Route::post('search_items', 'API\ItemsController@search');
    Route::get('items/{item}', 'API\ItemsController@show');
    Route::delete('items/{item}', 'API\ItemsController@delete');

    Route::post('items', 'API\ItemsController@store');
    Route::post('items/{item}', 'API\ItemsController@update');
    Route::get('category_items/{category}', 'API\ItemsController@items_by_category');


    Route::get('orders', 'API\OrdersController@index');
    Route::get('orders/{order}', 'API\OrdersController@show');
    Route::delete('orders/{order}', 'API\OrdersController@delete');
    Route::get('current_orders', 'API\OrdersController@current_orders');
    Route::get('previous_orders', 'API\OrdersController@previous_orders');

    Route::post('orders', 'API\OrdersController@store'); //TODO
    Route::post('orders/{order}', 'API\OrdersController@update');//TODO
    Route::get('favorite_orders', 'API\OrdersController@favorite_orders');//TODO


});
