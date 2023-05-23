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
use App\Http\Controllers\Dash\Masters\YardsController;
use App\Http\Controllers\Dash\Masters\RatingController;
use App\Http\Controllers\Dash\Masters\InspectionController;
use App\Http\Controllers\Dash\Masters\ChargesController;
use App\Http\Controllers\Dash\Masters\TermsController;
use App\Http\Controllers\Dash\Masters\SalesAgreementController;
use App\Http\Controllers\Dash\Masters\OverheadChargesController;
use App\Http\Controllers\Dash\Masters\CourierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        Route::group(['prefix'=>'accounts','namespace'=>'Dash'],function(){
        //upload images in temprary file and get 
        Route::post('/upload-documents',  'CommonController@uploadDocuments')->name('multiple-image-upload-temp');
        Route::post('/fetch-document', 'CommonController@fetchDocuments')->name('get-images-temp');
        Route::post('/delete-document', 'CommonController@deleteDocument')->name('delete-temp-image');
        Route::post('/rotate-image', 'CommonController@rotateImage')->name('rotate-image');

        Route::post('/slider-images', function(Request $request){

           $data =   DB::table($request->table)->where($request->table_referance_filed_name,$request->id)->where('deleted_at',null)->get();



         $view =  view('components.dash.view.dropzone-slider',['data' => $data ,'tableImageFiledName' => $request->tableImageFiledName, 'editableImagesPath' =>$request->editableImagesPath ])->render();

         return response(['status' => true ,'view' => $view]);

        } )->name('slider-images');

        //common methods end 
        });

        Route::post('country-list','Dash/StateCityController@countryList')->name('country-list');
        Route::post('state-list','Dash/StateCityController@stateList')->name('state-list');
        Route::post('city-list','Dash/StateCityController@cityList')->name('city-list');



        Route::group(['prefix'=>'accounts','namespace'=>'Dash\Accounts','as' => 'accounts.'],function(){

            Route::group(['prefix'=>'payments','as' => 'payments.'],function(){

                Route::get('drcrnotes',function(){
                    return view('dash.content.accounts.payments.drcrnotes');
                })->name('drcrnotes');

                Route::get('allocation',function(){
                    return view('dash.content.accounts.payments.allocation.create');
                })->name('allocation');

                // Route::get('/','PaymentsController@index')->name('index');
                 Route::get('/create','PaymentsController@create')->name('create');
                 Route::post('/store','PaymentsController@store')->name('store');
                // Route::get('edit/{id}','PaymentsController@edit')->name('edit');
                // Route::post('/delete', 'PaymentsController@destroy')->name('delete'); 
                // Route::post('/delete-multiple','PaymentsController@deleteMultiple')->name('delete-multiple');
                // Route::post('/update-status','PaymentsController@updateStatus')->name('update-status');
            });
        });


        Route::post('social-media-action', function(){
            return view('dash.content.users.social_media_action');
        })->name('social-media-action');

        Route::group(['prefix'=>'stock-manager','namespace'=>'Dash','as' => 'stock-manager.'],function(){
            Route::get('/',function(){ return view('dash.content.blank',['message' => " Stock Manager listing Page "]); });
            Route::get('/create',function(){ return view('dash.content.blank' ,['message' => " Add New Stock Manager  Page "]);  });
        });

        /* Route::group(['prefix'=>'inquries','namespace'=>'Dash','as' => 'inquries.'],function(){
            Route::get('/',function(){ return view('dash.content.inquiry.create'); });
            Route::get('/create',function(){ return view('dash.content.inquiry.create'); });
        }); */

        Route::group(['prefix'=>'inquiries','namespace'=>'Dash','as' => 'inquiries.'],function(){
            Route::get('/','InquiryController@index')->name('index');
            Route::get('/create','InquiryController@create')->name('create');
            Route::post('/store','InquiryController@store')->name('store');
            Route::get('edit/{id}','InquiryController@edit')->name('edit');
            Route::post('/delete', 'InquiryController@destroy')->name('delete'); 
            Route::post('/delete-multiple','InquiryController@deleteMultiple')->name('delete-multiple');   
            //Route::post('/update-status','InquiryController@updateStatus')->name('update-status');  
        });

        Route::group(['prefix'=>'reauction','namespace'=>'Dash','as' => 'reauction.'],function(){
            Route::get('/',function(){ return view('dash.content.reauction.create'); });
            Route::get('/create',function(){ return view('dash.content.reauction.create'); });
        });

        Route::group(['prefix'=>'courier','namespace'=>'Dash','as' => 'courier.'],function(){
            Route::get('/',function(){ return view('dash.content.courier.create'); });
            Route::get('/create',function(){ return view('dash.content.courier.create'); });

        });

        Route::group(['prefix'=>'vehicles','namespace'=>'Dash','as' => 'vehicles.'],function(){
         
            Route::get('/',function(){ return view('dash.content.vehicles.create'); });
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
       
            Route::get('/',function(){ return view('dash.content.proforma.create'); });
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
            Route::post('/check-uid-exist','ClientController@checkUidExist')->name('check-uid-exist');  
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

        Route::group(['prefix'=>'erp-expenses','namespace'=>'Dash','as' => 'erp-expenses.'],function(){
            Route::get('/',function(){ return view('dash.content.erp-expenses.create'); });
        });

        Route::group(['prefix'=>'erp-logistics','namespace'=>'Dash','as' => 'erp-logistics.'],function(){
            Route::get('/',function(){ return view('dash.content.erp-logistics.create'); });
        });

        Route::group(['prefix'=>'overhead-expenses','namespace'=>'Dash','as' => 'overhead-expenses.'],function(){
            Route::get('/',function(){ return view('dash.content.overhead-expenses.create'); });
        });       

        Route::group(['prefix'=>'erp/shipment','as' => 'erp/shipment.'],function(){

            Route::group(['prefix'=>'roro-shipment','as' => 'roro-shipment.'],function(){
                Route::get('/',function(){ return view('dash.content.shipment.roro-shipment.create'); 
                });
            });
            Route::group(['prefix'=>'container-group','as' => 'container-group.'],function(){
                Route::get('/',function(){ return view('dash.content.shipment.container_group.create'); 
                });
            });
        
        });

        Route::group(['prefix'=>'spare-parts','namespace'=>'Dash','as' => 'spare-parts.'],function(){

            Route::group(['prefix'=>'purchase','as' => 'purchase.'],function(){
                Route::get('/',function(){ return view('dash.content.spare_parts.purchase.create'); });
            });

            Route::group(['prefix'=>'sales','as' => 'sales.'],function(){
                Route::get('/',function(){ return view('dash.content.spare_parts.sales.create'); });
            });
            
        });

        Route::group(['prefix'=>'masters','namespace'=>'Dash\Masters','as' => 'masters.'],function(){

            Route::group(['prefix'=>'common','as' => 'common.'],function(){

                Route::group(['prefix'=>'yards','as' => 'yards.'],function(){
                    Route::get('/','YardsController@index')->name('index');
                    Route::get('/create','YardsController@create')->name('create');
                    Route::post('/store','YardsController@store')->name('store');
                    Route::get('edit/{id}','YardsController@edit')->name('edit');
                    Route::post('/delete', 'YardsController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','YardsController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','YardsController@updateStatus')->name('update-status');
                });

            });

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

            Route::group(['prefix'=>'invoices','as' => 'invoices.'],function(){

                Route::group(['prefix'=>'charges','as' => 'charges.'],function(){
                    Route::get('/','ChargesController@index')->name('index');
                    Route::get('/create','ChargesController@create')->name('create');
                    Route::post('/store','ChargesController@store')->name('store');
                    Route::get('edit/{id}','ChargesController@edit')->name('edit');
                    Route::post('/delete', 'ChargesController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','ChargesController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','ChargesController@updateStatus')->name('update-status');

                });

                Route::group(['prefix'=>'terms','as' => 'terms.'],function(){
                    Route::get('/','TermsController@index')->name('index');
                    Route::get('/create','TermsController@create')->name('create');
                    Route::post('/store','TermsController@store')->name('store');
                    Route::get('edit/{id}','TermsController@edit')->name('edit');
                    Route::post('/delete', 'TermsController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','TermsController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','TermsController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'payment-terms','as' => 'payment-terms.'],function(){
                    Route::get('/','PaymentTermsController@index')->name('index');
                    Route::get('/create','PaymentTermsController@create')->name('create');
                    Route::post('/store','PaymentTermsController@store')->name('store');
                    Route::get('edit/{id}','PaymentTermsController@edit')->name('edit');
                    Route::post('/delete', 'PaymentTermsController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','PaymentTermsController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','PaymentTermsController@updateStatus')->name('update-status');
                });


                Route::group(['prefix'=>'hs-code','as' => 'hs-code.'],function(){
                    Route::get('/',function(){ return  view('dash.content.masters.invoices.hs_code.create');  });
                    Route::get('/create',function(){ return view('dash.content.masters.invoices.hs_code.create'); });
                });

                Route::group(['prefix'=>'sales-agreement','as' => 'sales-agreement.'],function(){
                    Route::get('/','SalesAgreementController@index')->name('index');
                    Route::get('/create','SalesAgreementController@create')->name('create');
                    Route::post('/store','SalesAgreementController@store')->name('store');
                    Route::get('edit/{id}','SalesAgreementController@edit')->name('edit');
                    Route::post('/delete', 'SalesAgreementController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','SalesAgreementController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','SalesAgreementController@updateStatus')->name('update-status');
                });
            });


            Route::group(['prefix'=>'inspection','as' => 'inspection.'],function(){
                Route::get('/','InspectionController@index')->name('index');
                Route::get('/create','InspectionController@create')->name('create');
                Route::post('/store','InspectionController@store')->name('store');
                Route::get('edit/{id}','InspectionController@edit')->name('edit');
                Route::post('/delete', 'InspectionController@destroy')->name('delete'); 
                Route::post('/delete-multiple','InspectionController@deleteMultiple')->name('delete-multiple');
                Route::post('/update-status','InspectionController@updateStatus')->name('update-status');
            });

            
            Route::group(['prefix'=>'erp','as' => 'erp.'],function(){

                Route::group(['prefix'=>'overhead-charges','as' => 'overhead-charges.'],function(){
                    Route::get('/','OverheadChargesController@index')->name('index');
                    Route::get('/create','OverheadChargesController@create')->name('create');
                    Route::post('/store','OverheadChargesController@store')->name('store');
                    Route::get('edit/{id}','OverheadChargesController@edit')->name('edit');
                    Route::post('/delete', 'OverheadChargesController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','OverheadChargesController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','OverheadChargesController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'courier','as' => 'courier.'],function(){
                    Route::get('/','CourierController@index')->name('index');
                    Route::get('/create','CourierController@create')->name('create');
                    Route::post('/store','CourierController@store')->name('store');
                    Route::get('edit/{id}','CourierController@edit')->name('edit');
                    Route::post('/delete', 'CourierController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','CourierController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','CourierController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'vendor','as' => 'vendor.'],function(){
                    Route::get('/',function(){ return  view('dash.content.masters.erp.vendor.create');  });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.vendor.create'); });
                });
                Route::group(['prefix'=>'tax','as' => 'tax.'],function(){
                    Route::get('/',function(){ return  view('dash.content.masters.erp.tax.create');  });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.tax.create'); });
                });

                Route::group(['prefix'=>'shipid','as' => 'shipid.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.erp.shipid.create'); });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.shipid.create'); });
                });

                Route::group(['prefix'=>'logistics/fee','as' => 'logistics/fee.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.erp.logistics_fee.create'); });
                    Route::get('/create',function(){ return view('dash.content.masters.erp.logistics_fee.create'); });
                });

                Route::group(['prefix'=>'online-payments','as' => 'online-payments.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.erp.online_payments.create'); });
                });

                Route::group(['prefix'=>'expenses','as' => 'expenses.'],function(){
                    Route::get('/','ExpensesController@index')->name('index');
                    Route::get('/create','ExpensesController@create')->name('create');
                    Route::post('/store','ExpensesController@store')->name('store');
                    Route::get('edit/{id}','ExpensesController@edit')->name('edit');
                    Route::post('/delete', 'ExpensesController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','ExpensesController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','ExpensesController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'vendor-type','as' => 'vendor-type.'],function(){
                    Route::get('/','VendorTypeController@index')->name('index');
                    Route::get('/create','VendorTypeController@create')->name('create');
                    Route::post('/store','VendorTypeController@store')->name('store');
                    Route::get('edit/{id}','VendorTypeController@edit')->name('edit');
                    Route::post('/delete', 'VendorTypeController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','VendorTypeController@deleteMultiple')->name('delete-multiple');   
                    Route::post('/update-status','VendorTypeController@updateStatus')->name('update-status');  
                });
            });

            Route::group(['prefix'=>'crm','as' => 'crm.'],function(){

                Route::group(['prefix'=>'rating','as' => 'rating.'],function(){
                    Route::get('/','RatingController@index')->name('index');
                    Route::get('/create','RatingController@create')->name('create');
                    Route::post('/store','RatingController@store')->name('store');
                    Route::get('edit/{id}','RatingController@edit')->name('edit');
                    Route::post('/delete', 'RatingController@destroy')->name('delete'); 
                    Route::post('/delete-multiple','RatingController@deleteMultiple')->name('delete-multiple');
                    Route::post('/update-status','RatingController@updateStatus')->name('update-status');
                });

                Route::group(['prefix'=>'black-list','as' => 'black-list.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.crm.blacklist.create'); })->name('create');
                    Route::get('/create',function(){ return view('dash.content.masters.crm.blacklist.create'); })->name('create');
                });
                
                Route::group(['prefix'=>'mail-service','as' => 'mail-service.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.crm.mail_service.create'); })->name('create');
                    Route::get('/create',function(){ return view('dash.content.masters.crm.mail_service.create'); })->name('create');
                });

            });

            Route::group(['prefix'=>'freight','as' => 'freight.'],function(){
                
                Route::group(['prefix'=>'ocean-freight','as' => 'ocean-freight.'],function(){
                    Route::get('/',function(){ return view('dash.content.masters.freight.ocean-freight.create'); })->name('create');
                });

            });

        });

        Route::group(['prefix'=>'common','namespace'=>'Common','as' => 'common.'],function(){

            Route::group(['prefix'=>'accouncements','as'=>'accouncements.'],function(){
                Route::get('/',function(){ return view('dash.content.common.announcements.create'); });
            });

            Route::group(['prefix'=>'shipping-schedule','as'=>'shipping-schedule.'],function(){
                Route::get('/',function(){ return view('dash.content.common.shipping_schedule.create'); });
            });
        });

    });

});



// Route::get('register',function(){
//     return view('dash.auth.register');
// });