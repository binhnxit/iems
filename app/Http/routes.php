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

Route::group(['middleware' => 'guest'], function(){
	Route::get('login', [ 'as'=>'getLogin', 'uses'=>'Auth\AuthController@getLogin']);
	Route::post('login', [ 'as'=>'postLogin', 'uses'=>'Auth\AuthController@postLogin']);
	Route::get('reg', [ 'as'=>'getReg', 'uses'=>'Auth\AuthController@getRegister']);
	Route::post('reg', [ 'as'=>'postReg', 'uses'=>'Auth\AuthController@postRegister']);

});
Route::group(['middleware' => 'auth'], function(){
	Route::get('/', [ 'as'=>'index', 'uses'=>'HomeController@index']);
	Route::get('logout', 'Auth\AuthController@logout');
	Route::get('profile/{username}', 'Auth\AuthController@profile');
	Route::post('changeAvatar', 'Auth\AuthController@changeAvatar');
	Route::post('changeFullname', 'Auth\AuthController@changeFullname');
	Route::post('changeEmail', 'Auth\AuthController@changeEmail');
	Route::get('inex', ['as'=>'inex','uses'=>'InExController@index']);
	Route::post('inex/addCat', ['as'=>'inex.addCat','uses'=>'InExController@addCat']);
	Route::post('inex/addIeData', ['as'=>'inex.addIeData','uses'=>'InExController@addIeData']);
	Route::get('inex/delCat/{id}', ['as'=>'inex.delCat','uses'=>'InExController@delCat']);
	Route::get('inex/showInfoCat', ['as'=>'inex.showInfoCat','uses'=>'InExController@showInfoCat']);
	Route::post('inex/editCat', ['as'=>'inex.showInfoCat','uses'=>'InExController@editCat']);
	Route::get('inex/showInfoIeData', ['as'=>'inex.showInfoIeData','uses'=>'InExController@showInfoIeData']);
	Route::post('inex/editIeData', ['as'=>'inex.editIeData','uses'=>'InExController@editIeData']);
	Route::get('inex/delIeData/{id}', ['as'=>'inex.delIeData','uses'=>'InExController@delIeData']);


});
Route::get('404',['as'=>'404' ,'uses'=>function(){
	return view('404');
} ]);

	
	

