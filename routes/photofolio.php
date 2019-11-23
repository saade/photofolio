<?php

Route::group(['as' => 'photofolio.'], function () {
    Route::get('login',  ['uses' => '\SaadeMotion\Photofolio\Http\Controllers\PhotofolioAuthController@login',     'as' => 'login']);
    Route::post('login', ['uses' => '\SaadeMotion\Photofolio\Http\Controllers\PhotofolioAuthController@postLogin', 'as' => 'postlogin']);
    Route::post('logout',  ['uses' => '\SaadeMotion\Photofolio\Http\Controllers\PhotofolioAuthController@logout',   'as' => 'logout']);

    Route::group(['middleware' => 'photofolio.admin'], function () {
        Route::get('/', ['uses' => '\SaadeMotion\Photofolio\Http\Controllers\PhotofolioController@index', 'as' => 'dashboard']);

        Route::resource('category', '\SaadeMotion\Photofolio\Http\Controllers\CategoryController')->except('show');
        Route::resource('portifolio', '\SaadeMotion\Photofolio\Http\Controllers\PortifolioController')->except('show');
        Route::resource('portifolio.item', '\SaadeMotion\Photofolio\Http\Controllers\PortifolioItemController')->only([
            'store', 'update', 'destroy'
        ]);
    });
});

//Asset Routes
Route::get('photofolio-assets', ['uses' => '\SaadeMotion\Photofolio\Http\Controllers\PhotofolioController@assets', 'as' => 'photofolio_assets']);
