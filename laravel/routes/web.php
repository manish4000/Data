<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\Masters\TypeController;
use App\Http\Controllers\Admin\Masters\VechileMasterController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\GoogleV3CaptchaController;
use App\Http\Controllers\Admin\MasterDataTranslationController;
use App\Http\Controllers\Admin\MenuGroupController;
use App\Http\Controllers\Admin\SiteLanguageController;
use App\Http\Controllers\Admin\WebCaptionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Dash\CompanyUsers;
use App\Models\User;

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
        return redirect(route('dashboard'));
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

Route::group([ 'middleware' => 'auth', 'prefix' => 'admin' ], function() {


    Route::post('users/delete','Admin\UserController@destroy')->name('users.delete');
    Route::resource('users', 'Admin\UserController');
    Route::get('users/update-status/{id}','Admin\UserController@updateStatus')->name('users.update-status');

    Route::resource('roles', 'Admin\RoleController');
    Route::resource('site-languages', 'Admin\SiteLanguageController');

    Route::post('site-languages/delete', [SiteLanguageController::class, 'destroy'])->name('site-languages.destroy');

    Route::resource('menu', 'Admin\MenuController');
    Route::resource('permissions', 'Admin\PermissionController');
    Route::post('permissions/delete', 'Admin\PermissionController@destroy');
    Route::resource('menu-groups', 'Admin\MenuGroupController');
    Route::post('menu-groups/delete', [MenuGroupController::class, 'destroy'])->name('menu-groups.destroy');
    Route::resource('vehicle-type', 'Admin\Masters\TypeController');

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
        Route::get('/create','CompanyController@create')->name('create');

        Route::get('/create-test',function(){
            return view('content.admin.company.test');
        });

        Route::post('/store', 'CompanyController@store')->name('store');
        Route::get('edit/{id}','CompanyController@edit')->name('edit');
        Route::post('update/{id}','CompanyController@update')->name('update');
        Route::post('/delete', 'CompanyController@destroy')->name('delete');

        Route::post('state-list','CompanyController@stateList')->name('state-list');
        Route::post('city-list','CompanyController@cityList')->name('city-list');

        Route::group(['prefix' =>'permission' ,'as' => 'permission.','namespace' => 'Company' ],function(){
            Route::get('/', 'PermissionController@index')->name('index');
            Route::get('/create', 'PermissionController@create')->name('create');
            Route::post('/store', 'PermissionController@store')->name('store');
            Route::get('edit/{id}','PermissionController@edit')->name('edit');
            Route::post('/delete', 'PermissionController@destroy')->name('delete');
            Route::post('/position','PermissionController@updateCompanyPermissionPosition')->name('update-position');   
        });

        Route::group(['prefix' =>'plans' ,'as' => 'plans.','namespace' => 'Company' ],function(){
            Route::get('/', 'PlanController@index')->name('index');
            Route::get('/create', 'PlanController@create')->name('create');
            Route::post('/store', 'PlanController@store')->name('store');
            Route::get('edit/{id}','PlanController@edit')->name('edit');
            Route::post('/delete', 'PlanController@destroy')->name('delete');   
            Route::post('/delete-multiple','PlanController@deleteMultiple')->name('delete-multiple');
        });
        Route::group(['prefix' =>'plan-permission' ,'as' => 'plansPermission.','namespace' => 'Company' ],function(){
            Route::get('/', 'PlanPermissionController@index')->name('index');
            Route::post('/store', 'PlanPermissionController@store')->name('store');
        });

        Route::group(['prefix' =>'module' ,'as' => 'module.','namespace' => 'Company' ],function(){
            Route::get('/', 'ModuleController@index')->name('index');
            Route::get('/create', 'ModuleController@create')->name('create');
            Route::post('/store', 'ModuleController@store')->name('store');
            Route::get('edit/{id}','ModuleController@edit')->name('edit');
            Route::post('/delete', 'ModuleController@destroy')->name('delete');   
            Route::post('/delete-multiple','ModuleController@deleteMultiple')->name('delete-multiple');
        });

        Route::group(['prefix' =>'menu-groups' ,'as' => 'menu-groups.','namespace' => 'Company' ],function(){
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
            Route::post('update-menu-position','MenuGroupController@updateMenuPosition')->name('update-menu-position');

        });

    });

    Route::group(['prefix' => 'language-translation','as'=> 'language_translation.'], function () {

        Route::group(['prefix' => 'web-caption','as'=> 'web_caption.'], function () {

            Route::get('/', [WebCaptionController::class, 'index'])->name('index');
            Route::get('/add', [WebCaptionController::class, 'create'])->name('create');
            Route::post('/store', [WebCaptionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WebCaptionController::class, 'edit'])->name('edit');
            Route::post('/delete', [WebCaptionController::class, 'destroy'])->name('delete');   
            //this route for add language file in language folder for multiple language 
            Route::get('generate-locale-file',[WebCaptionController::class, 'getLocalfile'] );

        });

        Route::group(['prefix' => 'master-data-translation','as'=> 'master_data_translation.'], function () {

            Route::get('/', [MasterDataTranslationController::class, 'index'])->name('index');

            Route::get('/edit/{id}', [MasterDataTranslationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MasterDataTranslationController::class, 'update'])->name('update');

            });

        });




    /* Route Masters */
    Route::group(['prefix' => 'masters'], function () {

        // Route::get('/vehicle/{model}', [VechileMasterController::class, 'index'])->name('masters-vehicle'); 
        // Route::post('/vehicle/{model}/store', [VechileMasterController::class, 'store'])->name('masters-vehicle-store');
        // Route::post('/vehicle/{model}/update-status', [VechileMasterController::class, 'updateStatus'])->name('masters-vehicle-update-status');      
        // Route::post('/vehicle/{model}/delete/{id}', [VechileMasterController::class, 'destroy'])->name('masters-vehicle-delete');
        // Route::get('/vehicle/{model}/edit/{id}', [VechileMasterController::class, 'edit'])->name('masters-vehicle-edit');
        // Route::post('/vehicle/{model}/getChildList', [VechileMasterController::class,'getChildList']);     



        Route::group(['prefix' => 'vehicle'],function(){
            Route::group(['prefix' => 'type'],function(){
                Route::get('/', [TypeController::class, 'index'])->name('masters-vehicle-type'); 
                Route::post('/store', [TypeController::class, 'store'])->name('masters-vehicle-type-store');
                Route::post('/update-status', [TypeController::class, 'updateStatus'])->name('masters-vehicle-type-update-status');      
                Route::post('/delete', [TypeController::class, 'destroy'])->name('masters-vehicle-type-delete');
                Route::get('/edit/{id}', [TypeController::class, 'edit'])->name('masters-vehicle-type-edit');
                Route::get('/add', [TypeController::class, 'add'])->name('masters-vehicle-type-add');
                Route::get('/create', [TypeController::class, 'create'])->name('masters-vehicle-type-create');
                Route::post('/getChildList', [TypeController::class,'getChildList']);
                Route::post('/delete-multiple', [TypeController::class,'deleteMultiple'])->name('masters-vehicle-type-delete-multiple');
            });
        });
    });

});




// Set Locale
// $webLanguages = \App\Models\SiteLanguage::get(['alias']);
// if ($webLanguages) {
//     foreach ( $webLanguages as $lang ) {
//         Route::get($lang->alias, function() use ($lang){
//             session(['locale' => $lang->alias]);
//             return back();
//         });
//     }
// }
