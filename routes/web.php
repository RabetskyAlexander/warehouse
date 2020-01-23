<?php

Route::get('/','MainController@index');

Auth::routes();

Route::group(['prefix' => 'products'], function()
{
    Route::get('search','ProductController@search');

    Route::get('get/analog/product-id','ProductController@getAnalogByProductId');

    Route::get('get/analog/code-id','ProductController@getAnalogByCodeId');

    Route::get('get/analog/type-id','ProductController@getAnalogByTypeId');

    Route::get('roller-search','ProductController@rollerSearch');

    Route::get('absorber-search','ProductController@absorberSearch');

    Route::get('break-horse-search','ProductController@breakHoseSearch');

    Route::get('/','MainController@products');
});

Route::group(['prefix' => 'products', 'middleware' => ['auth']], function()
{
    Route::get('edit/{id}','ProductController@edit');

    Route::get('update','ProductController@update');

    Route::get('copy','ProductController@copy');

    Route::post('image/add','ProductController@imageAdd');

    Route::get('image/remove','ProductController@imageRemove');

    Route::get('code/add','ProductController@codeAdd');

    Route::get('code/remove','ProductController@codeRemove');

    Route::match(['get', 'post'], 'add','ProductController@add');
});

Route::get('product-types/search', 'ProductTypeController@search');
Route::group(['prefix' => 'product-types', 'middleware' => ['auth']], function()
{
    Route::match(['get', 'post'], 'add', 'ProductTypeController@add');

    Route::get('/view/{id}', 'ProductTypeController@view');
});

Route::group(['prefix' => 'brands', 'middleware' => ['auth']], function()
{
    Route::get('/','BrandController@index');

    Route::get('/search','BrandController@search');

    Route::match(['get', 'post'], '/add', 'BrandController@add');

    Route::get('/view/{id}','BrandController@view');

    Route::get('/update-status','BrandController@updateStatus');
});

Route::group(['prefix' => 'manufacturers', 'middleware' => ['auth']], function()
{
    Route::get('/','ManufactureController@index');

    Route::get('/search','ManufactureController@search');

    Route::get('/update-status','ManufactureController@updateStatus');
});

Route::group(['prefix' => 'crosses', 'middleware' => ['auth']], function()
{
    Route::get('remove','ProductCrossController@remove');

    Route::get('add','ProductCrossController@add');
});

Route::group(['prefix' => 'product-attributes', 'middleware' => ['auth']], function()
{
    Route::get('search','ProductAttributeController@search');

    Route::get('remove','ProductAttributeController@remove');

    Route::get('add','ProductAttributeController@add');
});

Route::group(['prefix' => 'product-attribute-types', 'middleware' => ['auth']], function()
{
    Route::get('search', 'ProductAttributeTypeController@search');

    Route::match(['get', 'post'], 'add', 'ProductAttributeTypeController@add');

    Route::get('view/{id}','ProductAttributeTypeController@view');
});

Route::get('codes/search','CodeController@search');
Route::group(['prefix' => 'codes', 'middleware' => ['auth']], function()
{
    Route::match(['get', 'post'],'add','CodeController@add');

    Route::get('view/{code_id}','CodeController@view');
});

Route::group(['prefix' => 'clients', 'middleware' => ['auth']], function()
{
    Route::get('index','ClientController@index');

    Route::get('view/{id}','ClientController@view');

    Route::get('search','ClientController@search');

    Route::post('update','ClientController@update');

    Route::match(['get', 'post'],'add','ClientController@add');

    Route::get('unselect','ClientController@unselect');
});

Route::group(['prefix' => 'client-cars', 'middleware' => ['auth']], function()
{
    Route::get('view/{id}','ClientCarController@view');

    Route::get('select/{id}','ClientCarController@select');

    Route::post('update','ClientCarController@update');

    Route::match(['get', 'post'],'add','ClientCarController@add');

    Route::get('product/add','ClientCarController@productAdd');
});

Route::group(['prefix' => 'cars', 'middleware' => ['auth']], function()
{
    Route::get('models/search','CarModelController@search');

    Route::get('modifications/search','CarModificationController@search');
});








