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

Route::get('/excel', function () {
    return Excel::download(new VisitsPerMonth, 'products.xlsx');
});
Route::get('/', function () {
    return redirect("admin");
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    
    Route::get('grafica', 'GraficasController@index');
    Route::get('state', 'ChildrenController@state');
    Route::get('municipality', 'ChildrenController@municipality');
    Route::get('parish', 'ChildrenController@parish');
    Route::post('generals/results', 'ChildrenController@searchResult');
    Route::resource('children','ChildrenController');
    Route::get('{country_id}/searchStateCountry', 'ChildrenController@searchStateCountry');
    Route::get('{state_id}/searchMunicipalityState', 'ChildrenController@searchMunicipalityState');
    Route::get('{municipality_id}/searchParishMunicipality', 'ChildrenController@searchParishMunicipality');
    Route::get('children/parents/{child_id}',"ParentsController@index");
    Route::get('children/parents/{child_id}/create',"ParentsController@create");
    Route::post('children/parents/{child_id}/store',"ParentsController@store");
    Route::get('children/parents/{parent_id}/{child_id}',"ParentsController@show");
    Route::get('children/parents/{parent_id}/{child_id}/edit',"ParentsController@edit");
    Route::put('children/parents/{parent_id}/{child_id}/update',"ParentsController@update");
    Route::delete('children/parents/{parent_id}/{id}/destroy',"ParentsController@destroy");
    Route::get('children/visits/{children_id}',"VisitsController@index");
    Route::get('children/visits/{children_id}/create',"VisitsController@create");
    Route::get('children/visits/{children_id}/graphicsVisit',"VisitsController@graphicsVisit");
    Route::post('children/visits/{children_id}/store',"VisitsController@store");
    Route::get('children/visits/{visit_id}/{children_id}/edit',"VisitsController@edit");
    Route::delete('children/visits/{id}/{children_id}/destroy',"VisitsController@destroy");
    Route::post('children/visits/{visit_id}/update',"VisitsController@update");
    Route::get('/formulas/inventories/{formula_id}',"InventoriesController@index");
    Route::get('/formulas/inventories/{formula_id}/create',"InventoriesController@create");
    Route::post('/formulas/inventories/{formula_id}/store',"InventoriesController@store");
    Route::get('/formulas/inventories/{id}/{formula_id}/edit',"InventoriesController@edit");
    Route::put('/formulas/inventories/{id}/{formula_id}/update',"InventoriesController@update");
    Route::resource('/reportes',"ReportsController");
    Route::post('reporte/reportVisitsDate',"ReportsController@reportVisitsDate");
    Route::post('reporte/searchResult',"ReportsController@searchResult");
    Route::get('reporte/visitas',"ChildrenController@reportVisits");
    Route::get('reporte/general',"ChildrenController@GeneralReport");
    Route::get('reporte/entrega-formulas',"ChildrenController@ReportFormulaDelivery");
    Route::post('search/visitas-fechas',"ChildrenController@reportVisitsDate");
    Route::post('search/visitas-delivered',"ReportsController@reportVisitsDelivered");
    Route::get('excel/visitas',"ReportsController@ExcelVisited");
    Route::get('excel/general',"ReportsController@ExcelGeneral");
    Route::get('excel/entregas',"ReportsController@ExcelDelivery");
    // Route::delete('children/visits/{parent_id}/{id}/destroy',"VisitsController@destroy");
    // Route::resource("parents",'ParentsController');
});
