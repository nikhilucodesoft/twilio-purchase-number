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
Route::middleware(['auth'])->group(function () {
Route::get('/available-list', 'PricingController@index');
Route::match(array('GET', 'POST'),'/phone_number_price', 'PricingController@phone_numbers')->name('phone_number_price');
Route::get('/purchase_number/{number}/{country_code}','PricingController@purchase_number')->name('purchase_number');
Route::post('purchase_number','PricingController@post_address')->name('purchase_number_form');
Route::get('/home', 'PricingController@index')->name('home');


Route::resource('appointment', 'AppointmentController');

Route::resource(
    'available_number', 'AvailableNumberController', ['only' => ['index']]
);

Route::resource(
    'lead_source', 'LeadSourceController', ['except' => ['index', 'create', 'show']]
);

Route::get(
    'lead/summary-by-lead-source',
    ['as' => 'lead.summary_by_lead_source',
     'uses' => 'LeadController@summaryByLeadSource'
    ]
);

Route::get(
    'lead/summary-by-city',
    ['as' => 'lead.summary_by_city',
     'uses' => 'LeadController@summaryByCity'
    ]
);

Route::get(
    'dashboard',
    ['as' => 'dashboard',
     'uses' => 'LeadController@dashboard'
    ]
);

Route::resource(
    'lead', 'LeadController', ['only' => ['store']]
);












});
 
 
 