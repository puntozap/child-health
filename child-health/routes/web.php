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

});
