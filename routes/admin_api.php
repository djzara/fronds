<?php

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], static function () {
    Route::group(['namespace' => 'Auth'], static function () {
        Route::post('verify', ['as' => 'admin.auth.verify', 'uses' => 'UserVerificationController@loginToken']);
        Route::post('resolve', ['as' => 'admin.auth.resolve', 'uses' => 'UserVerificationController@finishLogin']);
    });
    // all actions will have the name /{actionName} as the path, the full path in the api being
    // api/{version}/{actionName}
    Route::group(['namespace' => 'Action'], static function () {
        Route::apiResource('page', 'PageActionController');
        Route::delete('menus/item', ['as' => 'admin.menu.item.delete','uses' => 'MenuActionController@removeMenuItem']);
        Route::apiResource('menus', 'MenuActionController');
    });
});
