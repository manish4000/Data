<?php


/*
|--------------------------------------------------------------------------
| Dash Routes
|--------------------------------------------------------------------------

|
*/

use App\Http\Controllers\Dash\Auth\LoginController;
use App\Http\Controllers\Dash\LanguageController;
use Illuminate\Support\Facades\Route;





Route::middleware('dash')->name('dash')->group(function(){
    Route::get('lang/{locale}',[LanguageController::class,'swap']);

    Route::group(['namespace' =>'Dash\Auth','middleware'=>'guest:dash'],function(){
        Route::get('/',"LoginController@showLoginForm");
        Route::post('login',"LoginController@login")->name('login');    
        Route::get('password/reset',"ForgotPasswordController@showLinkRequestForm")->name('password.request');    
        Route::post('password/reset',"ForgotPasswordController@sendResetLinkEmail")->name('password.email');          
    });

    Route::group(['middleware' => 'dashauth'], function () {

        Route::group(['prefix'=>'stock-manager','namespace'=>'Dash','as' => 'stock-manager.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => " Stock Manager listing Page "]); });
            Route::get('/create',function(){ return view('dash.content.blank' ,['message' => " Add New Stock Manager  Page "]);  });
        });

        Route::group(['prefix'=>'inquries','namespace'=>'Dash','as' => 'inquries.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => "Inquries listing Page "]); });
        });

        Route::group(['prefix'=>'proforma-manager','namespace'=>'Dash','as' => 'proforma-manager.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => "Proforma Manager listing Page "]);  });
            Route::get('/create',function(){ return view('dash.content.blank' ,['message' => " Add New Proforma Manager Page "]); });
        });

        Route::group(['prefix'=>'members','namespace'=>'Dash','as' => 'members.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => "Members listing Page "]);  });
            Route::get('/create',function(){ return view('dash.content.blank' ,['message' => " Add New Member Page "]); });
        });

        Route::get('/logout','Dash\Auth\LoginController@logout')->name('logout');
        Route::get('/dashboard',function(){return view('dash.content.dashboard');})->name('home');

        Route::group(['prefix'=>'users','namespace'=>'Dash','as' => 'users.'],function(){
            Route::get('/','UserController@index')->name('index');
            Route::get('/create','UserController@create')->name('create');
            Route::post('/store','UserController@store')->name('store');
            Route::get('edit/{id}','UserController@edit')->name('edit');
            Route::post('/delete', 'UserController@destroy')->name('delete');   
        });
        Route::group(['prefix'=>'testimonial','namespace'=>'Dash','as' => 'testimonial.'],function(){
            Route::get('/','TestimonialController@index')->name('index');
            Route::get('/create','TestimonialController@create')->name('create');
            Route::post('/store','TestimonialController@store')->name('store');
            Route::get('edit/{id}','TestimonialController@edit')->name('edit');
            Route::post('/delete', 'TestimonialController@destroy')->name('delete');  
            Route::post('/delete-multiple','TestimonialController@deleteMultiple')->name('delete-multiple'); 
        });

        Route::group(['prefix'=>'bank-details','namespace'=>'Dash','as' => 'bank-details.'],function(){
            Route::get('/','BankDetailsController@index')->name('index');
            Route::get('/create','BankDetailsController@create')->name('create');
            Route::post('/store','BankDetailsController@store')->name('store');
            Route::get('edit/{id}','BankDetailsController@edit')->name('edit');
            Route::post('/delete', 'BankDetailsController@destroy')->name('delete');   
            Route::post('/status', 'BankDetailsController@updateStatus')->name('status');   
            Route::post('/delete-multiple','BankDetailsController@deleteMultiple')->name('delete-multiple');

        });

        Route::post('state-list','Dash\BankDetailsController@stateList')->name('state-list');
        Route::post('city-list','Dash\BankDetailsController@cityList')->name('city-list');

    });

});



// Route::get('register',function(){
//     return view('dash.auth.register');
// });