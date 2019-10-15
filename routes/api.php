<?php

Route::group(['namespace' => 'Auth'], function () 
{
    Route::post('login', ['uses' => 'PermissionController@defineScope']);
});

Route::group(['prefix' => 'inputs'], function () 
{
    Route::group(['middleware' => 'auth:api'], function () 
    {
        Route::group(['middleware' => 'scope:ROLE_USER,ROLE_ADMIN'], function () 
        {
            Route::get('rows/{rows}', ['uses' => 'InputController@loadInputs']);
            Route::get('{id}', ['uses' => 'InputController@getInput']);
            Route::post('search', ['uses' => 'InputController@searchInputsByProduct']);
        });
        Route::group(['middleware' => 'scope:ROLE_ADMIN'], function () 
        {
            Route::post('/', ['uses' => 'InputController@saveInput']);
            Route::put('{id}', ['uses' => 'InputController@editInput']);
            Route::delete('{id}', ['uses' => 'InputController@deleteInput']);
        });
    });
});

Route::group(['prefix' => 'outputs'], function () 
{
    Route::group(['middleware' => 'auth:api'], function () 
    {
        Route::group(['middleware' => 'scope:ROLE_USER,ROLE_ADMIN'], function () 
        {
            Route::get('rows/{rows}', ['uses' => 'OutputController@loadOutputs']);
            Route::get('{id}', ['uses' => 'OutputController@getOutput']);
            Route::post('search', ['uses' => 'OutputController@searchOutputsByProduct']);
        });
        Route::group(['middleware' => 'scope:ROLE_ADMIN'], function () 
        {
            Route::post('/', ['uses' => 'OutputController@saveOutput']);
            Route::put('{id}', ['uses' => 'OutputController@editOutput']);
            Route::delete('{id}', ['uses' => 'OutputController@deleteOutput']);
        });
    });
});

Route::group(['prefix' => 'products'], function () 
{
    Route::group(['middleware' => 'auth:api'], function () 
    {
        Route::group(['middleware' => 'scope:ROLE_USER,ROLE_ADMIN'], function () 
        {
            Route::get('all', ['uses' => 'ProductController@loadAllProducts']);
            Route::get('rows/{rows}', ['uses' => 'ProductController@loadProducts']);
            Route::get('/barcode/{barcode}', ['uses' => 'ProductController@getProductByBarcode']);
            Route::get('{id}', ['uses' => 'ProductController@getProduct']);
            Route::post('search', ['uses' => 'ProductController@searchProducts']);
        });
        Route::group(['middleware' => 'scope:ROLE_ADMIN'], function () 
        {
            Route::post('/', ['uses' => 'ProductController@saveProduct']);
            Route::put('{id}', ['uses' => 'ProductController@editProduct']);
            Route::delete('{id}', ['uses' => 'ProductController@deleteProduct']);
        });
    });
});

Route::group(['prefix' => 'providers'], function () 
{
    Route::group(['middleware' => 'auth:api'], function () 
    {
        Route::group(['middleware' => 'scope:ROLE_USER,ROLE_ADMIN'], function () 
        {
            Route::get('all', ['uses' => 'ProviderController@loadAllProviders']);
            Route::get('rows/{rows}', ['uses' => 'ProviderController@loadProviders']);
            Route::get('{id}', ['uses' => 'ProviderController@getProvider']);
            Route::post('search', ['uses' => 'ProviderController@searchProviders']);
        });
        Route::group(['middleware' => 'scope:ROLE_ADMIN'], function () 
        {
            Route::post('/', ['uses' => 'ProviderController@saveProvider']);
            Route::put('{id}', ['uses' => 'ProviderController@editProvider']);
            Route::delete('{id}', ['uses' => 'ProviderController@deleteProvider']);
        });
    });
});

Route::group(['prefix' => 'users'], function () 
{
    Route::group(['middleware' => 'auth:api'], function () 
    {
        Route::group(['middleware' => 'scope:ROLE_USER,ROLE_ADMIN'], function () 
        {
            Route::get('rows/{rows}', ['uses' => 'UserController@loadUsers']);
            Route::get('{id}', ['uses' => 'UserController@getUser']);
            Route::post('search', ['uses' => 'UserController@searchUsers']);
        });
        Route::group(['middleware' => 'scope:ROLE_ADMIN'], function () 
        {
            Route::put('{id}', ['uses' => 'UserController@editUser']);
            Route::delete('{id}', ['uses' => 'UserController@deleteUser']);
        });
    });
    Route::post('/', ['uses' => 'UserController@saveUser']);
});