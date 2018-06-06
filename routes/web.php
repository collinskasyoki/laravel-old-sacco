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

Route::middleware(['auth'])->group(function(){
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['setup'])->group(function(){

//Route::get('find', 'SearchController@searchmembers');

Route::get('dashboard', 'MainController@index');
Route::get('dashboard/users', 'MembersController@index');
Route::get('dashboard/loans', 'LoansController@index');
Route::get('dashboard/shares', 'SharesController@index');

Route::post('admin/members', 'MembersController@store');
Route::get('admin/members/find', 'SearchController@searchmembers');
Route::get('admin/members/{id}', 'MembersController@getMember')->where('id', '[0-9]+');
Route::put('admin/members/{id}/update', 'MembersController@update')->where('id', '[0-9]+');
Route::get('admin/members{id}/get', 'MembersController@onlyget')->where('id', '[0-9]+');

Route::post('admin/shares', 'SharesController@store')->where('id', '[0-9]+');
Route::put('admin/shares/{id}/edit', 'SharesController@update')->where('id', '[0-9]+');
Route::delete('admin/shares/{id}/delete', 'SharesController@destroy')->where('id', '[0-9]+');
Route::get('admin/shares/find', 'SearchController@searchshares');

Route::post('admin/loans', 'LoansController@store');
Route::get('admin/loans/{id}/guarantors', 'LoansController@showGuarantors')->where('id', '[0-9]+');
Route::post('admin/loans/{id}/pay', 'LoansController@pay')->where('id', '[0-9]+');
Route::get('admin/loans/{id}/payments', 'LoansController@payments')->where('id', '[0-9]+');
Route::get('admin/loans/eligibility/{id}', 'LoansController@verify')->where('id', '[0-9]+');
Route::post('admin/loans/{id}/delete', 'LoansController@destroy')->where('id', '[0-9]+');
Route::get('admin/loans/find', 'SearchController@searchloans');
Route::get('admin/loans/add', 'LoansController@add_loan_verify_members');

});


Route::get('dashboard/settings', 'SettingsController@index');
Route::post('admin/settings', 'SettingsController@store');
Route::post('admin/settings/quick', 'SettingsController@store_quick');
Route::put('admin/settings/{id}', 'SettingsController@update')->where('id', '[0-9]+');
Route::put('admin/settings/quick/{id}', 'SettingsController@update_quick')->where('id', '[0-9]+');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');