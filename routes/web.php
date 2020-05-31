<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::resource('contacts', 'ContactController');

Route::get('contacts/{contact}/delete', 'ContactController@destroy')->name('contacts.destroy.web');
Route::get('contacts/{contact}/track', 'ContactController@trackEvent')->name('contacts.track.event');
Route::post('contacts/import', 'ContactController@importData')->name('contacts.import');
