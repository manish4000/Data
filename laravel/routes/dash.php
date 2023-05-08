<?php


/*
|--------------------------------------------------------------------------
| Dash Routes
|--------------------------------------------------------------------------

|
*/

use App\Http\Controllers\Dash\Auth\LoginController;
use App\Http\Controllers\Dash\LanguageController;
use App\Http\Controllers\Dash\SocialMediaActionController;
use App\Http\Controllers\Dash\StateCityController;
use App\Http\Controllers\Dash\Erp\PaymentsController;

use Illuminate\Support\Facades\Route;

Route::middleware('dash')->name('dash')->group(function(){

    Route::post('login-with-admin',"Dash\Auth\LoginController@loginWithId")->name('login-with-admin');
    Route::get('lang/{locale}',[LanguageController::class,'swap']);

    Route::group(['namespace' =>'Dash\Auth','middleware'=>'guest:dash'],function(){
       Route::get('/',"LoginController@showLoginForm");
       Route::post('login',"LoginController@login")->name('login');
       Route::get('password/reset',"ForgotPasswordController@showLinkRequestForm")->name('password.request');
       Route::post('password/reset',"ForgotPasswordController@sendResetLinkEmail")->name('password.email');
    });

    Route::group(['middleware' => 'dashauth'], function () {

        Route::post('country-list','Dash/StateCityController@countryList')->name('country-list');
        Route::post('state-list','Dash/StateCityController@stateList')->name('state-list');
        Route::post('city-list','Dash/StateCityController@cityList')->name('city-list');



        Route::group(['prefix'=>'accounts','namespace'=>'Dash\Accounts','as' => 'accounts.'],function(){

            Route::group(['prefix'=>'payments','as' => 'payments.'],function(){
                Route::get('drcrnotes',function(){
                    return view('dash.content.accounts.payments.drcrnotes'); 
                })->name('drcrnotes');

                Route::get('/','PaymentsController@index')->name('index');
                Route::get('/create','PaymentsController@create')->name('create');
                Route::post('/store','PaymentsController@store')->name('store');
                Route::get('edit/{id}','PaymentsController@edit')->name('edit');
                Route::post('/delete', 'PaymentsController@destroy')->name('delete'); 
                Route::post('/delete-multiple','PaymentsController@deleteMultiple')->name('delete-multiple');
                Route::post('/update-status','PaymentsController@updateStatus')->name('update-status');
            });
        });


        Route::post('social-media-action', function(){
            return view('dash.content.users.social_media_action');
        })->name('social-media-action');

        Route::group(['prefix'=>'stock-manager','namespace'=>'Dash','as' => 'stock-manager.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => " Stock Manager listing Page "]); });
            Route::get('/create',function(){ return view('dash.content.blank' ,['message' => " Add New Stock Manager  Page "]);  });
        });

        Route::group(['prefix'=>'inquiries','namespace'=>'Dash','as' => 'inquiries.'],function(){
            Route::get('/',function(){ return  view('dash.content.blank',['message' => "Inquiry Manager listing Page "]);  });
            Route::get('/create',function(){ return view('dash.content.inquiry.create'); });
        });
        Route::group(['prefix'=>'vehicles','namespace'=>'Dash','as' => 'vehicles.'],function(){
            Route::get('/',function(){ return  view('dash.content.blank',['message' => "vehicles listing Page "]);  });
            Route::get('/create',function(){ return view('dash.content.vehicles.create'); });
        });

        Route::get('billing-info',function(){
            return view('dash.content.billing_info');  })->name('billing-info');

        Route::group(['prefix'=>'profile','as' => 'profile.','namespace'=>'Dash'],function(){
             Route::get('/','ProfileController@edit')->name('index');

         Route::post('update','ProfileController@updateProfile')->name('update');
        
            //  Route::get('/',function(){     return view('dash.content.company.profile');
            //  });

            

            //  Route::group(['prefix'=>'profile','as' => 'profile.'],function(){
            //     Route::get('/',function(){ return view('dash.content.company.profile'); });
           
        });
        
        


        Route::group(['prefix'=>'proforma-manager','namespace'=>'Dash','as' => 'proforma-manager.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => "Proforma Manager listing Page "]);  });
            Route::get('/create',function(){ return view('dash.content.proforma.create'); });
        });

        Route::group(['prefix'=>'members','namespace'=>'Dash','as' => 'members.'],function(){
            Route::get('/','ClientController@index')->name('index');
            Route::get('/create','ClientController@create')->name('create');
            Route::post('/store','ClientController@store')->name('store');
            Route::get('edit/{id}','ClientController@edit')->name('edit');
            Route::post('/delete', 'ClientController@destroy')->name('delete'); 
            Route::post('/delete-multiple','ClientController@deleteMultiple')->name('delete-multiple');   
            Route::post('/update-status','ClientController@updateStatus')->name('update-status');  
        });
        
        Route::group(['prefix'=>'company','namespace'=>'Dash','as' => 'company.'],function(){
            Route::get('/create',function(){ return view('dash.content.company.create'); });



        });

        Route::get('/logout','Dash\Auth\LoginController@logout')->name('logout');
        Route::get('/dashboard',function(){return view('dash.content.dashboard');})->name('home');

        Route::group(['prefix'=>'users','namespace'=>'Dash','as' => 'users.'],function(){
            Route::get('/','UserController@index')->name('index');
            Route::get('/create','UserController@create')->name('create');
            Route::post('/store','UserController@store')->name('store');
            Route::get('edit/{id}','UserController@edit')->name('edit');
            Route::post('/delete', 'UserController@destroy')->name('delete'); 
            Route::post('/delete-multiple','UserController@deleteMultiple')->name('delete-multiple');   
            Route::post('login-from-admin','UserController@loginFromAdmin')->name('login-form-admin');
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
            Route::get('send-otp','BankDetailsController@sendOtp')->name('send-otp');
        });

        Route::post('state-list','Dash\BankDetailsController@stateList')->name('state-list');
        Route::post('city-list','Dash\BankDetailsController@cityList')->name('city-list');

        Route::group(['prefix'=>'masters','namespace'=>'Dash','as' => 'masters.'],function(){

            Route::group(['prefix'=>'erp','namespace'=>'Dash','as' => 'erp.'],function(){

                Route::group(['prefix'=>'vendor','namespace'=>'Dash','as' => 'vendor.'],function(){
                    Route::get('/',function(){ return  view('dash.content.masters.erp.vendor.create');  });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.vendor.create'); });
                });
            });

        });

    });

});



// Route::get('register',function(){
//     return view('dash.auth.register');
// });