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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'SiteController@index')->name('site');
Route::post('/calificar', 'SiteController@calificar')->name('calificar');

Route::resource('/plan_estudio', 'PlanEstudioController');
Route::resource('/asignatura', 'AsignaturaController');
Route::resource('/contenido', 'ContenidoController');
Route::resource('/bibliografia', 'BibliografiaController');
Route::resource('/bibliografia_contenido', 'Bibliografia_contenidoController');
Route::get('/bibliografia_contenido_add/{contenido_id}/{biblografia_id}', 'Bibliografia_contenidoController@add');
Route::get('/bibliografia_contenido_remove/{id}', 'Bibliografia_contenidoController@remove');
Route::resource('/asignatura_contenido', 'Asignatura_contenidoController');






