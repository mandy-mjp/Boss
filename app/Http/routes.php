<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['domain' => env('BOSS_DOMAIN')],function(){
    // 认证路由...
    Route::get('/auth/login', 'Auth\AuthController@getLogin');
    Route::post('/auth/login', 'Auth\AuthController@postLogin');
    Route::get('/auth/logout', 'Auth\AuthController@getLogout');
});

Route::group(['domain' => env('BOSS_DOMAIN'), 'namespace' => 'Admin', 'middleware' => ['auth', 'authorize']], function () {
    //Route::get('/', 'DashboardController@welcome');
    Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@dash');
    Route::get('/error/403', function() {return view('errors.403');});
    Route::get('/error/404', function() {return view('errors.404');});

    //perm 权限设置
    //role
    Route::get('/perm/role', 'RoleController@index');
    Route::get('/perm/role/create', 'RoleController@create');
    Route::post('/perm/role/create', 'RoleController@store');
    Route::get('/perm/role/{role}/update', 'RoleController@show');
    Route::post('/perm/role/{role}/update', 'RoleController@update');
    Route::post('/perm/role/{role}/delete', 'RoleController@destroy');

    //user
    Route::get('/perm/user', 'UserController@index');
    Route::get('/perm/user/create', 'UserController@create');
    Route::post('/perm/user/create', 'UserController@store');
    Route::get('/perm/user/{user}/update', 'UserController@show');
    Route::post('/perm/user/{user}/update', 'UserController@update');
    Route::get('/perm/user/{user}/password', 'UserController@showPassword');
    Route::post('/perm/user/{user}/password', 'UserController@editPassword');
    Route::post('/perm/user/{user}/reset', 'UserController@resetPassword');
    Route::post('/perm/user/{user}/delete', 'UserController@destroy');

    //menu
    Route::get('/perm/menu', 'MenuController@index');
    Route::get('/perm/menu/create', 'MenuController@create');
    Route::post('/perm/menu/create', 'MenuController@store');
    Route::get('/perm/menu/{menu}/update', 'MenuController@show');
    Route::post('/perm/menu/{menu}/update', 'MenuController@update');
    Route::post('/perm/menu/{menu}/order', 'MenuController@displayOrder');
    Route::post('/perm/menu/{menu}/delete', 'MenuController@destroy');

    //permission
    Route::get('/perm/menu/{menu}/permission', 'PermissionController@index');
    Route::get('/perm/permission/create/{menu}', 'PermissionController@create');
    Route::post('/perm/permission/create/{menu}', 'PermissionController@store');
    Route::get('/perm/permission/{permission}/update', 'PermissionController@show');
    Route::post('/perm/permission/{permission}/update', 'PermissionController@update');
    Route::post('/perm/permission/{permission}/delete', 'PermissionController@destroy');

    //goods
    Route::get('/goods/index/{state?}','GoodsController@index');
    Route::get('/goods/check/{state?}','GoodsController@check');
    //Route::put('/goods/check/{id}','GoodsController@update');
    Route::post('/goods/index/{state?}','GoodsController@index');
    Route::get('/goods/action/{action}/{id}','GoodsController@action');
    Route::get('/goods/location_fix/{id}','GoodsController@location_fix');
    Route::post('/goods/location_fix','GoodsController@location_edit');
    Route::get('/goods/edit/{id}','GoodsController@edit');
    Route::post('/goods/edit/{id}','GoodsController@update');

    //upload
    Route::post('/goods/upload','GoodsController@upload');

    //orders
    Route::get('/orders/check','OrderController@check');
    Route::get('/orders/refund','OrderController@refund');
    Route::get('/orders/allorders','OrderController@allOrders');
    Route::get('/orders/lookorders','OrderController@editOrders');

    //fund资金
    Route::get('/fund/buyfund','OrderController@check');
    Route::get('/fund/reportfund','OrderController@check');
    Route::get('/orders/putfund','OrderController@check');
});





Route::group(['domain' => env('STORE_DOMAIN'), 'namespace' => 'Store'], function () {

    Route::get('/goods/audit', 'GoodsAuditController@index');
    Route::get('/goods/audit/{state}', 'GoodsAuditController@reviewGood');
    Route::get('/goods/manager', 'GoodsManagerController@index');

    Route::get('/goods/manager/{state}', 'GoodsManagerController@managerGood');
    Route::post('/goods/managers/{action}/{id}', 'GoodsManagerController@doGoods');
    Route::post('/goods/manager', 'GoodsManagerController@searchGood');


    //资源路由 对应goods操作
    Route::resource('/goods','GoodsController');
    Route::post('/goods/upload','GoodsController@upload');
    Route::get('/gift/add','GoodsController@gift');
    Route::post('/gift/add','GoodsController@gift_store');
    Route::get('/gift/guide/{id}','GoodsController@gift_guide');
    Route::get('/spec/add',function(){
        return view('store.goods.spec');
    });
    Route::post('/spec/add','GoodsController@spec');


});


Route::group(['prefix' => 'v1','namespace' => 'Api'], function() {
    Route::post('/upload/test', 'ImageController@upload');
    Route::post('/order', 'OrderController@addOrder');

});






