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
use App\Http\Controllers\Dash\Masters\ExpensesController;
use App\Http\Controllers\Dash\Masters\VendorTypeController;
use App\Http\Controllers\Dash\MAsters\MainCategoryController;
use App\Http\Controllers\Dash\Masters\SubCategoryController;

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


        //upload images in temprary file and get 
        Route::post('/upload-documents',  'Dash/CommomController@uploadDocuments')->name('multiple-image-upload-temp');
        Route::post('/fetch-document', 'Dash/CommomController@fetchDocuments')->name('get-images-temp');
        Route::post('/delete-document', 'Dash/CommomController@deleteDocument')->name('delete-temp-image');
        //common methods end 

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

        Route::group(['prefix'=>'masters','namespace'=>'Dash\Masters','as' => 'masters.'],function(){

            Route::group(['prefix'=>'spare-parts','as' => 'spare-parts.'],function(){

                Route::group(['prefix'=>'main-category','as' => 'main-category.'],function(){
                    Route::get('/','MainCategoryController@index')->name('index');
                    Route::get('/create','MainCategoryController@create')->name('create');
                    Route::post('/store','MainCategoryController@store')->name('store');
                    Route::get('edit/{id}','MainCategoryController@edit')->name('edit');
                    Route::post('/delete', 'MainCategoryController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','MainCategoryController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','MainCategoryController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'sub-category','as' => 'sub-category.'],function(){
                    Route::get('/','SubCategoryController@index')->name('index');
                    Route::get('/create','SubCategoryController@create')->name('create');
                    Route::post('/store','SubCategoryController@store')->name('store');
                    Route::get('edit/{id}','SubCategoryController@edit')->name('edit');
                    Route::post('/delete', 'SubCategoryController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','SubCategoryController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','SubCategoryController@updateStatus')->name('update-status');
                });
            });

            Route::group(['prefix'=>'erp','as' => 'erp.'],function(){

                Route::group(['prefix'=>'vendor','as' => 'vendor.'],function(){
                    Route::get('/',function(){ return  view('dash.content.masters.erp.vendor.create');  });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.vendor.create'); });
                });
                Route::group(['prefix'=>'shipid','as' => 'shipid.'],function(){
                    Route::get('/create',function(){ return view('dash.content.masters.erp.shipid.create'); });
                });

                Route::group(['prefix'=>'expenses','as' => 'expenses.'],function(){
                    // Route::get('/',function(){ return view('dash.content.masters.erp.expenses.create'); });
                    Route::get('/','ExpensesController@index')->name('index');
                    Route::get('/create','ExpensesController@create')->name('create');
                    Route::post('/store','ExpensesController@store')->name('store');
                    Route::get('edit/{id}','ExpensesController@edit')->name('edit');
                    Route::post('/delete', 'ExpensesController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','ExpensesController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','ExpensesController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'vendor-type','as' => 'vendor-type.'],function(){
                    // Route::get('/',function(){ return view('dash.content.masters.erp.expenses.create'); });
                    Route::get('/','VendorTypeController@index')->name('index');
                    Route::get('/create','VendorTypeController@create')->name('create');
                    Route::post('/store','VendorTypeController@store')->name('store');
                    Route::post('/add','VendorTypeController@add')->name('add');
                    Route::post('/getChildList','VendorTypeController@getChildList');
                    Route::get('edit/{id}','VendorTypeController@edit')->name('edit');
                    Route::post('/delete', 'VendorTypeController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','VendorTypeController@deleteMultiple')->name('delete-multiple');   
                    Route::post('/update-status','VendorTypeController@updateStatus')->name('update-status');  
                });
            });

            Route::group(['prefix'=>'crm','as' => 'crm.'],function(){

                Route::group(['prefix'=>'black-list','as' => 'black-list.'],function(){
                    Route::get('/create',function(){ return view('dash.content.masters.crm.blacklist.create'); })->name('create');
                });
                
                Route::group(['prefix'=>'mail-service','as' => 'mail-service.'],function(){
                    Route::get('/create',function(){ return view('dash.content.masters.crm.mail_service.create'); })->name('create');
                });

            });

        });

    });

});



// Route::get('register',function(){
//     return view('dash.auth.register');
// });