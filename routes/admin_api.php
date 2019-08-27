<?php

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], static function () {
    Route::group(['namespace' => 'Auth'], static function () {
        Route::post('verify', ['as' => 'admin.auth.verify', 'uses' => 'UserVerificationController@loginToken']);
        Route::post('resolve', ['as' => 'admin.auth.resolve', 'uses' => 'UserVerificationController@finishLogin']);
    });
});
