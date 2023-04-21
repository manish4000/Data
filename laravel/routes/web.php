<?php

use App\Http\Controllers\Admin\Common\CityController;
use App\Http\Controllers\Admin\Common\RegionController;
use App\Http\Controllers\Admin\Common\CountryController;
use App\Http\Controllers\Admin\Common\StateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\Masters\TypeController;
use App\Http\Controllers\Admin\Masters\VechileMasterController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\GoogleV3CaptchaController;
use App\Http\Controllers\Admin\MasterDataTranslationController;
use App\Http\Controllers\Admin\Masters\FuelController;
use App\Http\Controllers\Admin\Masters\TransmissionController;
use App\Http\Controllers\Admin\Masters\ColorController;
use App\Http\Controllers\Admin\Masters\ModelController;
use App\Http\Controllers\Admin\Masters\ExtGradeController;
use App\Http\Controllers\Admin\Masters\IntGradeController;
use App\Http\Controllers\Admin\Masters\VehicleStatusController;
use App\Http\Controllers\Admin\Masters\AssociationController;
use App\Http\Controllers\Admin\Masters\BusinessTypeController;
use App\Http\Controllers\Admin\Masters\SupportLanguagesController;
use App\Http\Controllers\Admin\Masters\MarketingStatusController;
use App\Http\Controllers\Admin\Masters\SubTypeController;
use App\Http\Controllers\Admin\Masters\DealsInController;
use App\Http\Controllers\Admin\Masters\MakeController;
use App\Http\Controllers\Admin\MenuGroupController;
use App\Http\Controllers\Admin\SiteLanguageController;
use App\Http\Controllers\Admin\WebCaptionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Dash\CompanyUsers;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

// Auth::routes();



Auth::routes();


Route::get('google-v3-recaptcha', [GoogleV3CaptchaController::class, 'index']);
Route::post('validate-g-recaptcha', [GoogleV3CaptchaController::class, 'validateGCaptch']);

    Route::post('/2fa', function () {
        return redirect()->route('dashboard');
    })->name('2fa');

Route::get('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete.registration');

Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('dashboard', [StaterkitController::class, 'home'])->name('dashboard')->middleware(['auth']);
// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/boxed', [StaterkitController::class, 'layout_boxed'])->name('layout-boxed');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::get('dashboard', [StaterkitController::class, 'home'])->name('dashboard')->middleware(['auth']);

Route::post('change-view',function(Request $request){
    $request->session()->put('list-type', $request->view);
    return response()->json(['status' => true]);
})->name('change-view');

Route::group([ 'middleware' => ['auth'], 'prefix' => 'admin' ], function() {



    Route::get('data-migrate','Admin\DataImportController@importData');

    Route::group(['as' => 'users.','prefix' => 'users'] ,function(){

        Route::post('login-from-admin','Admin\UserController@loginFromAdmin')->name('login-form-admin');
        Route::post('delete','Admin\UserController@destroy')->name('delete');
        Route::post('delete-multiple','Admin\UserController@deleteMultiple')->name('delete-multiple');
        Route::get('edit/{id}', 'Admin\UserController@edit')->name('edit');
        Route::get('permission/{id}', 'Admin\UserController@showPermission')->name('permission');
        Route::post('permission/update', 'Admin\UserController@updatePermission')->name('update-permission');
        Route::get('update-status/{id}','Admin\UserController@updateStatus')->name('update-status');
        Route::post('add-two-step-verification','Admin\UserController@addTwoStapVerification')->name('2fa');
        Route::get('delete-two-step-verification/{id}','Admin\UserController@deleteTwoStapVerification')->name('delete-2fa');
        Route::post('update-two-step-verification','Admin\UserController@updateTwoStapVerification')->name('2fa-update');
        Route::post('verify-two-step-verification','Admin\UserController@verifyTwoStapVerification')->name('verify-2fa');
        Route::post('update-verify-two-step-verification','Admin\UserController@updateverifyTwoStapVerification')->name('update-verify-2fa');

    });

    Route::resource('users', 'Admin\UserController');
    Route::resource('roles', 'Admin\RoleController');

    Route::post('site-languages/delete-multiple', [SiteLanguageController::class, 'deleteMultiple'])->name('site-languages.delete-multiple');
    
    Route::resource('site-languages', 'Admin\SiteLanguageController');
    Route::post('site-languages/delete', [SiteLanguageController::class, 'destroy'])->name('site-languages.destroy');


    Route::resource('menu', 'Admin\MenuController');
    Route::resource('permissions', 'Admin\PermissionController');
    Route::post('permissions/delete', 'Admin\PermissionController@destroy');
    Route::resource('menu-groups', 'Admin\MenuGroupController');
    Route::post('menu-groups/delete', [MenuGroupController::class, 'destroy'])->name('menu-groups.destroy');
    Route::post('menu-groups/delete-multiple', [MenuGroupController::class,'deleteMultiple'])->name('menu-groups.delete-multiple');
    Route::resource('vehicle-type', 'Admin\Masters\TypeController');

    Route::group(['prefix' =>'accounts' ,'as' => 'accounts.','namespace' => 'Admin' ],function(){
        Route::group(['prefix' =>'billing' ,'as' => 'billing.' ],function(){
            Route::get('/',function(){
                return view('content.admin.accounts.billing.create');
            } )->name('index');
        });
    
    });




    Route::group(['prefix' =>'masters/company/marketing-status' ,'as' => 'marketing-status.','namespace' => 'Admin' ],function(){
        Route::get('/', 'MarketingStatus@index')->name('index');
    });

    Route::group(['prefix' =>'department' ,'as' => 'department.','namespace' => 'Admin' ],function(){
        Route::get('/', 'DepartmentController@index')->name('index');
        Route::get('/create', 'DepartmentController@create')->name('create');
        Route::post('/store', 'DepartmentController@store')->name('store');
        Route::get('edit/{id}','DepartmentController@edit')->name('edit');
        Route::post('/delete', 'DepartmentController@destroy')->name('delete');   
        Route::post('/delete-multiple','DepartmentController@deleteMultiple')->name('delete-multiple');
    });

    // Menu Group Menus
    Route::get('menu-groups/{id}/menus', 'Admin\MenuGroupController@menus')->name('menu-groups.menus');
    Route::get('menu-groups/menu/{id}/edit', 'Admin\MenuGroupController@editMenu')->name('menu-groups.menu.edit');
    // Route::post('menu-groups/menu/{id}/update', 'App\Http\Controllers\Admin\MenuGroupController@updateMenu')->name('menu-groups.menu.update');
    Route::post('menu-groups/menu/{id}/update', 'Admin\MenuGroupController@updateMenu')->name('menu-groups.menu.update');
    Route::post('menu-groups/add-menu', 'Admin\MenuGroupController@addMenu')->name('menu-groups.add-menu');
    Route::post('menu-groups/delete-menu', 'Admin\MenuGroupController@destroyMenu')->name('menu-groups.delete-menu');
    

    // Company old  Routes
    // Route::group(['prefix' => 'company'], function () {
    //     Route::get('/', [CompanyController::class, 'index'])->name('company');
    //     Route::post('/store', [CompanyController::class, 'store'])->name('company-store');
    //     Route::post('/update', [CompanyController::class, 'update'])->name('company-update');
    //     Route::post('/update-status', [CompanyController::class, 'updateStatus'])->name('company-update-status');   
    //     Route::post('/delete/{id}', [CompanyController::class, 'destroy'])->name('company-delete');
    //     Route::get('/create', [CompanyController::class, 'create'])->name('company-create');
    //     Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('company-edit');
    //     Route::get('/show/{id}', [CompanyController::class, 'show'])->name('company-show');
    //     Route::get('/list', [CompanyController::class, 'list'])->name('company-list');
    //     Route::get('/getJsonList', [CompanyController::class,'getJsonList']);
    //     Route::get('/getDropDownFill', [CompanyController::class,'getDropDownFill']);
    //     Route::post('/check-shortname-exists', [CompanyController::class, 'checkShortNameExists'])->name('check-shortname-exists');
    // });

    Route::group(['prefix' => 'company','as'=> 'company.' ,'namespace' => 'Admin'], function () { 

        Route::get('/','CompanyController@index')->name('index');
        Route::get('/import-company-data','CompanyController@importDataFromJct');
        Route::get('/create','CompanyController@create')->name('create');

        Route::get('/create-test',function(){
            return view('content.admin.company.test');
        });

        Route::post('/store', 'CompanyController@store')->name('store');
        Route::get('edit/{id}','CompanyController@edit')->name('edit');
        Route::post('update/{id}','CompanyController@update')->name('update');
        Route::post('/delete', 'CompanyController@destroy')->name('delete');
        Route::post('/delete-multiple','CompanyController@deleteMultiple')->name('delete-multiple'); 

        Route::post('state-list','CompanyController@stateList')->name('state-list');
        Route::post('city-list','CompanyController@cityList')->name('city-list');
 
        Route::group(['namespace' => 'Company'],function(){

            Route::group(['prefix' =>'permission' ,'as' => 'permission.' ],function(){
                Route::get('/', 'PermissionController@index')->name('index');
                Route::get('/create', 'PermissionController@create')->name('create');
                Route::post('/store', 'PermissionController@store')->name('store');
                Route::get('edit/{id}','PermissionController@edit')->name('edit');
                Route::post('/delete', 'PermissionController@destroy')->name('delete');
                Route::post('/position','PermissionController@updateCompanyPermissionPosition')->name('update-position');   
            });

            Route::group(['prefix' =>'plans' ,'as' => 'plans.' ],function(){
                Route::get('/', 'PlanController@index')->name('index');
                Route::get('/create', 'PlanController@create')->name('create');
                Route::post('/store', 'PlanController@store')->name('store');
                Route::get('edit/{id}','PlanController@edit')->name('edit');
                Route::post('/delete', 'PlanController@destroy')->name('delete');   
                Route::post('/delete-multiple','PlanController@deleteMultiple')->name('delete-multiple');
            });

            Route::group(['prefix' =>'plan-permission' ,'as' => 'plansPermission.' ],function(){
                Route::get('/', 'PlanPermissionController@index')->name('index');
                Route::post('/store', 'PlanPermissionController@store')->name('store');
            });
            
            Route::group(['prefix' =>'module' ,'as' => 'module.'],function(){
                Route::get('/', 'ModuleController@index')->name('index');
                Route::get('/create', 'ModuleController@create')->name('create');
                Route::post('/store', 'ModuleController@store')->name('store');
                Route::get('edit/{id}','ModuleController@edit')->name('edit');
                Route::post('/delete', 'ModuleController@destroy')->name('delete');   
                Route::post('/delete-multiple','ModuleController@deleteMultiple')->name('delete-multiple');
            });
            
            Route::group(['prefix' =>'menu-groups' ,'as' => 'menu-groups.'],function(){
                Route::get('/', 'MenuGroupController@index')->name('index');
                Route::get('/create', 'MenuGroupController@create')->name('create');
                Route::post('/store', 'MenuGroupController@store')->name('store');
                Route::get('edit/{id}','MenuGroupController@edit')->name('edit');
                Route::post('/delete', 'MenuGroupController@destroy')->name('delete');   
                Route::get('{id}/menus', 'MenuGroupController@menus')->name('menus');
                Route::post('add-menu', 'MenuGroupController@addMenu')->name('add-menu');
                Route::get('menu/{id}/edit', 'MenuGroupController@editMenu')->name('menu.edit');
                Route::post('menu/{id}/update', 'MenuGroupController@updateMenu')->name('menu.update');
                Route::post('delete-menu', 'MenuGroupController@destroyMenu')->name('menu.delete');
                Route::post('/delete-multiple','MenuGroupController@deleteMultiple')->name('delete-multiple'); 
                Route::post('update-menu-position','MenuGroupController@updateMenuPosition')->name('update-menu-position');
    
            });
        }); 

    });

    Route::group(['prefix' => 'language-translation','as'=> 'language_translation.'], function () {

            Route::group(['prefix' => 'web-caption','as'=> 'web_caption.'], function () {

                Route::get('/', [WebCaptionController::class, 'index'])->name('index');
                Route::get('/add', [WebCaptionController::class, 'create'])->name('create');
                Route::post('/store', [WebCaptionController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [WebCaptionController::class, 'edit'])->name('edit');
                Route::post('/delete', [WebCaptionController::class, 'destroy'])->name('delete');  
                Route::post('/delete-multiple',[WebCaptionController::class, 'deleteMultiple'])->name('delete-multiple'); 
                //this route for add language file in language folder for multiple language 
                Route::get('generate-locale-file',[WebCaptionController::class, 'getLocalfile'] );

            });

            Route::group(['prefix' => 'master-data-translation','as'=> 'master_data_translation.'], function () {
            Route::get('/', [MasterDataTranslationController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [MasterDataTranslationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MasterDataTranslationController::class, 'update'])->name('update');
            });

        });

     
        //route Common
        
        Route::group(['prefix' => 'common','as' => 'common.'],function(){
            //routes of country module 
            Route::group(['prefix' => 'country' ,'as' => 'country.'],function(){
                Route::get('/', [CountryController::class, 'index'])->name('index'); 
                Route::get('/create', [CountryController::class, 'create'])->name('create');
                Route::post('/store', [CountryController::class, 'store'])->name('store');
                Route::post('/delete', [CountryController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('edit');
                Route::post('/delete-multiple', [CountryController::class,'deleteMultiple'])->name('delete-multiple');
            });
            //routes of country module 
            Route::group(['prefix' => 'state' ,'as' => 'state.'],function(){
                Route::get('/', [StateController::class, 'index'])->name('index'); 
                Route::get('/create', [StateController::class, 'create'])->name('create');
                Route::post('/store', [StateController::class, 'store'])->name('store');
                Route::post('/delete', [StateController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [StateController::class, 'edit'])->name('edit');
                Route::post('/delete-multiple', [StateController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'city' ,'as' => 'city.'],function(){
                Route::get('/', [CityController::class, 'index'])->name('index'); 
                Route::get('/create', [CityController::class, 'create'])->name('create');
                Route::post('/store', [CityController::class, 'store'])->name('store');
                Route::post('/delete', [CityController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [CityController::class, 'edit'])->name('edit');
                Route::post('/delete-multiple', [CityController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'region' ,'as' => 'region.'],function(){
                Route::get('/', [RegionController::class, 'index'])->name('index'); 
                Route::get('/create', [RegionController::class, 'create'])->name('create');
                Route::post('/store', [RegionController::class, 'store'])->name('store');
                Route::post('/delete', [RegionController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [RegionController::class, 'edit'])->name('edit');
                Route::post('/delete-multiple', [RegionController::class,'deleteMultiple'])->name('delete-multiple');
            });
        });


    /* Route Masters */
    Route::group(['prefix' => 'masters' ,'as' => 'masters.'], function () {

        Route::group(['prefix' => 'vehicle' ,'as' => 'vehicle.'],function(){
            //routes of type module 
            Route::group(['prefix' => 'type','as' => 'type.'],function(){

                Route::get('/', [TypeController::class, 'index'])->name('index'); 
                Route::post('/store', [TypeController::class, 'store'])->name('store');
                Route::post('/update-status', [TypeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [TypeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [TypeController::class, 'edit'])->name('edit');
                Route::get('/add', [TypeController::class, 'add'])->name('add');
                Route::get('/create', [TypeController::class, 'create'])->name('create');
                Route::post('/getChildList', [TypeController::class,'getChildList']);
                Route::post('/delete-multiple', [TypeController::class,'deleteMultiple'])->name('delete-multiple');
            });

            //routes of make module 

            Route::group(['prefix' => 'make' , 'as' => 'make.'],function(){
                Route::get('/', [MakeController::class, 'index'])->name('index'); 
                Route::post('/store', [MakeController::class, 'store'])->name('store');
                Route::post('/update-status', [MakeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [MakeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [MakeController::class, 'edit'])->name('edit');
                Route::get('/add', [MakeController::class, 'add'])->name('add');
                Route::get('/create', [MakeController::class, 'create'])->name('create');
                Route::post('/getChildList', [MakeController::class,'getChildList']);
                Route::post('/delete-multiple', [MakeController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'fuel' , 'as' => 'fuel.'],function(){
                Route::get('/', [FuelController::class, 'index'])->name('index'); 
                Route::post('/store', [FuelController::class, 'store'])->name('store');
                Route::post('/update-status', [FuelController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [FuelController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [FuelController::class, 'edit'])->name('edit');
                Route::get('/add', [FuelController::class, 'add'])->name('add');
                Route::get('/create', [FuelController::class, 'create'])->name('create');
                Route::post('/getChildList', [FuelController::class,'getChildList']);
                Route::post('/delete-multiple', [FuelController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'transmission' , 'as' => 'transmission.'],function(){
                Route::get('/', [TransmissionController::class, 'index'])->name('index'); 
                Route::post('/store', [TransmissionController::class, 'store'])->name('store');
                Route::post('/update-status', [TransmissionController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [TransmissionController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [TransmissionController::class, 'edit'])->name('edit');
                Route::get('/add', [TransmissionController::class, 'add'])->name('add');
                Route::get('/create', [TransmissionController::class, 'create'])->name('create');
                Route::post('/getChildList', [TransmissionController::class,'getChildList']);
                Route::post('/delete-multiple', [TransmissionController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'color' , 'as' => 'color.'],function(){
                Route::get('/', [ColorController::class, 'index'])->name('index'); 
                Route::post('/store', [ColorController::class, 'store'])->name('store');
                Route::post('/update-status', [ColorController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [ColorController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
                Route::get('/add', [ColorController::class, 'add'])->name('add');
                Route::get('/create', [ColorController::class, 'create'])->name('create');
                Route::post('/getChildList', [ColorController::class,'getChildList']);
                Route::post('/delete-multiple', [ColorController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'model' , 'as' => 'model.'],function(){
                Route::get('/', [ModelController::class, 'index'])->name('index'); 
                Route::post('/store', [ModelController::class, 'store'])->name('store');
                Route::post('/update-status', [ModelController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [ModelController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [ModelController::class, 'edit'])->name('edit');
                Route::get('/add', [ModelController::class, 'add'])->name('add');
                Route::get('/create', [ModelController::class, 'create'])->name('create');
                Route::post('/getChildList', [ModelController::class,'getChildList']);
                Route::post('/delete-multiple', [ModelController::class,'deleteMultiple'])->name('delete-multiple');
            });  
            
            Route::group(['prefix' => 'ext-grade' , 'as' => 'ext-grade.'],function(){
                Route::get('/', [ExtGradeController::class, 'index'])->name('index'); 
                Route::post('/store', [ExtGradeController::class, 'store'])->name('store');
                Route::post('/update-status', [ExtGradeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [ExtGradeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [ExtGradeController::class, 'edit'])->name('edit');
                Route::get('/add', [ExtGradeController::class, 'add'])->name('add');
                Route::get('/create', [ExtGradeController::class, 'create'])->name('create');
                Route::post('/getChildList', [ExtGradeController::class,'getChildList']);
                Route::post('/delete-multiple', [ExtGradeController::class,'deleteMultiple'])->name('delete-multiple');
            });
            
            Route::group(['prefix' => 'int-grade' , 'as' => 'int-grade.'],function(){
                Route::get('/', [IntGradeController::class, 'index'])->name('index'); 
                Route::post('/store', [IntGradeController::class, 'store'])->name('store');
                Route::post('/update-status', [IntGradeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [IntGradeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [IntGradeController::class, 'edit'])->name('edit');
                Route::get('/add', [IntGradeController::class, 'add'])->name('add');
                Route::get('/create', [IntGradeController::class, 'create'])->name('create');
                Route::post('/getChildList', [IntGradeController::class,'getChildList']);
                Route::post('/delete-multiple', [IntGradeController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'vehicle-status' , 'as' => 'vehicle-status.'],function(){
                Route::get('/', [VehicleStatusController::class, 'index'])->name('index'); 
                Route::post('/store', [VehicleStatusController::class, 'store'])->name('store');
                Route::post('/update-status', [VehicleStatusController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [VehicleStatusController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [VehicleStatusController::class, 'edit'])->name('edit');
                Route::get('/add', [VehicleStatusController::class, 'add'])->name('add');
                Route::get('/create', [VehicleStatusController::class, 'create'])->name('create');
                Route::post('/getChildList', [VehicleStatusController::class,'getChildList']);
                Route::post('/delete-multiple', [VehicleStatusController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'subtype' , 'as' => 'subtype.'],function(){
                Route::get('/', [SubTypeController::class, 'index'])->name('index'); 
                Route::post('/store', [SubTypeController::class, 'store'])->name('store');
                Route::post('/update-status', [SubTypeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [SubTypeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [SubTypeController::class, 'edit'])->name('edit');
                Route::get('/add', [SubTypeController::class, 'add'])->name('add');
                Route::get('/create', [SubTypeController::class, 'create'])->name('create');
                Route::post('/getChildList', [SubTypeController::class,'getChildList']);
                Route::post('/delete-multiple', [SubTypeController::class,'deleteMultiple'])->name('delete-multiple');
            });
            
        });
        
        Route::group(['prefix' => 'company' , 'as' => 'company.'],function(){
            
            Route::group(['prefix' => 'association' , 'as' => 'association.'],function(){
                Route::get('/', [AssociationController::class, 'index'])->name('index'); 
                Route::post('/store', [AssociationController::class, 'store'])->name('store');
                Route::post('/update-status', [AssociationController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [AssociationController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [AssociationController::class, 'edit'])->name('edit');
                Route::get('/add', [AssociationController::class, 'add'])->name('add');
                Route::get('/create', [AssociationController::class, 'create'])->name('create');
                Route::post('/getChildList', [AssociationController::class,'getChildList']);
                Route::post('/delete-multiple', [AssociationController::class,'deleteMultiple'])->name('delete-multiple');
            });
            
            Route::group(['prefix' => 'business-type' , 'as' => 'business-type.'],function(){
                Route::get('/', [BusinessTypeController::class, 'index'])->name('index'); 
                Route::post('/store', [BusinessTypeController::class, 'store'])->name('store');
                Route::post('/update-status', [BusinessTypeController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [BusinessTypeController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [BusinessTypeController::class, 'edit'])->name('edit');
                Route::get('/add', [BusinessTypeController::class, 'add'])->name('add');
                Route::get('/create', [BusinessTypeController::class, 'create'])->name('create');
                Route::post('/getChildList', [BusinessTypeController::class,'getChildList']);
                Route::post('/delete-multiple', [BusinessTypeController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'support-languages' , 'as' => 'support-languages.'],function(){
                Route::get('/', [SupportLanguagesController::class, 'index'])->name('index'); 
                Route::post('/store', [SupportLanguagesController::class, 'store'])->name('store');
                Route::post('/update-status', [SupportLanguagesController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [SupportLanguagesController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [SupportLanguagesController::class, 'edit'])->name('edit');
                Route::get('/add', [SupportLanguagesController::class, 'add'])->name('add');
                Route::get('/create', [SupportLanguagesController::class, 'create'])->name('create');
                Route::post('/getChildList', [SupportLanguagesController::class,'getChildList']);
                Route::post('/delete-multiple', [SupportLanguagesController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'marketing-status' , 'as' => 'marketing-status.'],function(){
                Route::get('/', [MarketingStatusController::class, 'index'])->name('index'); 
                Route::post('/store', [MarketingStatusController::class, 'store'])->name('store');
                Route::post('/update-status', [MarketingStatusController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [MarketingStatusController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [MarketingStatusController::class, 'edit'])->name('edit');
                Route::get('/add', [MarketingStatusController::class, 'add'])->name('add');
                Route::get('/create', [MarketingStatusController::class, 'create'])->name('create');
                Route::post('/getChildList', [MarketingStatusController::class,'getChildList']);
                Route::post('/delete-multiple', [MarketingStatusController::class,'deleteMultiple'])->name('delete-multiple');
            });

            Route::group(['prefix' => 'deals-in' , 'as' => 'deals-in.'],function(){
                Route::get('/', [DealsInController::class, 'index'])->name('index'); 
                Route::post('/store', [DealsInController::class, 'store'])->name('store');
                Route::post('/update-status', [DealsInController::class, 'updateStatus'])->name('update-status');      
                Route::post('/delete', [DealsInController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [DealsInController::class, 'edit'])->name('edit');
                Route::get('/add', [DealsInController::class, 'add'])->name('add');
                Route::get('/create', [DealsInController::class, 'create'])->name('create');
                Route::post('/getChildList', [DealsInController::class,'getChildList']);
                Route::post('/delete-multiple', [DealsInController::class,'deleteMultiple'])->name('delete-multiple');
            });

        });
        
    });

});