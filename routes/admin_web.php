<?php

Route::group(['namespace' => 'Admin'], static function () {
    Route::get('logout', ['as' => 'fronds.admin.home.logout', 'uses' => 'AdminController@logout']);
    Route::get('', ['as' => 'fronds.admin.home.login', 'uses' => 'AdminController@loginHome']);
    Route::post('', ['as' => 'fronds.admin.submit.login', 'uses' => 'AdminController@login']);
    Route::group(['middleware' => 'auth'], static function () {
        Route::get('manage', ['as' => 'fronds.admin.manage', 'uses' => 'AdminController@manage']);
    });
});
