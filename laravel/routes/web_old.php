<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\Masters\TypeController;
use App\Http\Controllers\Admin\Masters\VechileMasterController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('dashboard', [StaterkitController::class, 'home'])->name('home');
// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/boxed', [StaterkitController::class, 'layout_boxed'])->name('layout-boxed');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::group([ 'middleware' => 'auth', 'prefix' => 'admin' ], function() {
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    Route::resource('roles', 'App\Http\Controllers\Admin\RoleController');
    Route::resource('site-languages', 'App\Http\Controllers\Admin\SiteLanguageController');
    Route::resource('menu', 'App\Http\Controllers\Admin\MenuController');
    Route::resource('permissions', 'App\Http\Controllers\Admin\PermissionController');
    Route::resource('menu-groups', 'App\Http\Controllers\Admin\MenuGroupController');

    // Menu Group Menus
    Route::get('menu-groups/{id}/menus', 'App\Http\Controllers\Admin\MenuGroupController@menus')->name('menu-groups.menus');
    Route::get('menu-groups/menu/{id}/edit', 'App\Http\Controllers\Admin\MenuGroupController@editMenu')->name('menu-groups.menu.edit');
    Route::post('menu-groups/menu/{id}/update', 'App\Http\Controllers\Admin\MenuGroupController@updateMenu')->name('menu-groups.menu.update');
    Route::post('menu-groups/add-menu', 'App\Http\Controllers\Admin\MenuGroupController@addMenu')->name('menu-groups.add-menu');
    Route::delete('menu-groups/delete-menu/{id}', 'App\Http\Controllers\Admin\MenuGroupController@destroyMenu')->name('menu-groups.delete-menu');

    // Company Routes
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company');
        Route::post('/store', [CompanyController::class, 'store'])->name('company-store');
        Route::post('/update', [CompanyController::class, 'update'])->name('company-update');
        Route::post('/update-status', [CompanyController::class, 'updateStatus'])->name('company-update-status');   
        Route::post('/delete/{id}', [CompanyController::class, 'destroy'])->name('company-delete');
        Route::get('/create', [CompanyController::class, 'create'])->name('company-create');
        Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('company-edit');
        Route::get('/show/{id}', [CompanyController::class, 'show'])->name('company-show');
        Route::get('/list', [CompanyController::class, 'list'])->name('company-list');
        Route::get('/getJsonList', [CompanyController::class,'getJsonList']);
        Route::get('/getDropDownFill', [CompanyController::class,'getDropDownFill']);
        Route::post('/check-shortname-exists', [CompanyController::class, 'checkShortNameExists'])->name('check-shortname-exists');
    });

    /* Route Masters */
    Route::group(['prefix' => 'masters'], function () {

        Route::get('/vehicle/{model}', [VechileMasterController::class, 'index'])->name('masters-vehicle'); 
        Route::post('/vehicle/{model}/store', [VechileMasterController::class, 'store'])->name('masters-vehicle-store');
        Route::post('/vehicle/{model}/update-status', [VechileMasterController::class, 'updateStatus'])->name('masters-vehicle-update-status');      
        Route::post('/vehicle/{model}/delete/{id}', [VechileMasterController::class, 'destroy'])->name('masters-vehicle-delete');
        Route::get('/vehicle/{model}/edit/{id}', [VechileMasterController::class, 'edit'])->name('masters-vehicle-edit');
        Route::post('/vehicle/{model}/getChildList', [VechileMasterController::class,'getChildList']);     



        Route::group(['prefix' => 'vehicle-type'],function(){
            Route::group(['prefix' => 'type'],function(){
                Route::get('/', [TypeController::class, 'index'])->name('masters-vehicle-type-type'); 
                Route::post('/store', [TypeController::class, 'store'])->name('masters-vehicle-type-type-store');
                Route::post('/update-status', [TypeController::class, 'updateStatus'])->name('masters-vehicle-type-type-update-status');      
                Route::post('/delete/{id}', [TypeController::class, 'destroy'])->name('masters-vehicle-type-type-delete');
                Route::get('/edit/{id}', [TypeController::class, 'edit'])->name('masters-vehicle-type-type-edit');
                Route::post('/getChildList', [TypeController::class,'getChildList']);
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
