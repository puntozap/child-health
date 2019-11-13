<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("admin");
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('grafica', 'GraficasController@index');
    Route::resource('children','ChildrenController');
    Route::get('{country_id}/searchStateCountry', 'ChildrenController@searchStateCountry');
    Route::get('{state_id}/searchMunicipalityState', 'ChildrenController@searchMunicipalityState');
    Route::get('{municipality_id}/searchParishMunicipality', 'ChildrenController@searchParishMunicipality');
    Route::get('children/parents/{child_id}',"ParentsController@index");
    Route::get('children/parents/{child_id}/create',"ParentsController@create");
    Route::post('children/parents/{child_id}/store',"ParentsController@store");
    Route::get('children/parents/{parent_id}/{child_id}',"ParentsController@show");
    Route::get('children/parents/{parent_id}/{child_id}/edit',"ParentsController@edit");
    Route::put('children/parents/{parent_id}',"ParentsController@update");
    Route::put('children/parents/{parent_id}',"ParentsController@update");
    Route::delete('children/parents/{parent_id}/{id}/destroy',"ParentsController@destroy");
    // Route::resource("parents",'ParentsController');
});
