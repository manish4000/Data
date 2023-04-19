<?php

namespace App\Providers;

use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyPermission;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        try {

            Menu::get()->map(function ($permission) {
                Gate::define($permission->permission_slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }


        try {

            CompanyMenuGroupMenu::get()->map(function ($permission) {
                Gate::define($permission->permission_slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }




        // get all data from menu.json file
        // $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
        // $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);


        $groups = \App\Models\MenuGroup::with(['menu' => function($q) {
                   $q->where('parent_id', 0 )->where('type','menu')->orderBy('order');
                  }])->orderBy('order')->get();



        // $groups = \App\Models\MenuGroup::with(['menu' => function($q) {
        //     $q->where('parent_id', 0 )->where('show_in_sidebar',1);
        // }])->orderBy('order')->get();

        
        $companyMenu = \App\Models\Company\CompanyMenuGroup::with(['menu' => function($q){
                      $q->where('parent_id' ,0)->where('type','menu')->orderBy('order');
                      }])->orderBy('order')->get();
        

        $menuData = [];

        $companyMenuData = [];
        // $menuData[] = [ 
        //     "name" => "Dashboard", 
        //     "badge" => "2", 
        //     "badgeClass" => "badge badge-light-warning badge-pill ml-auto mr-1",
        //     "icon" => "home",
        //     "slug" => "",
        //     "submenu" => [
        //         [
        //           "url" => "dashboard/analytics",
        //           "name" => "Analytics",
        //           "icon" => "circle",
        //           "slug" => "dashboard-analytics"
        //         ],
        //         [
        //           "url" => "/",
        //           "name" => "eCommerce",
        //           "icon" => "circle",
        //           "slug" => "dashboard-ecommerce"
        //         ]
        //     ] 
        // ];

        // $title = "title";
        if ( isset($lang) && $lang != 'en' ) {
            $langId = \App\Models\SiteLanguage::where('alias', $lang)->first()->id;
        }
        //this is for admin menu 
        foreach ( $groups as $group ) {

            if ($group->is_display_title == 1) {
                $groupTitle = isset($lang) && $lang != 'en' && isset($group->title_languages[$langId]['title']) ? $group->title_languages[$langId]['title'] : $group->title;
                // dd($groupTitle);
                $menuData[] = [ "navheader" => $groupTitle, "slug" => $group['slug'] ];
            }
            $arrayData = [];
            if (isset($group->menu) && count($group->menu) > 0 ) {
                $menuData = $this->listSideNav($group->menu, $menuData);
            }
        }
        $verticalMenuData["menu"] = $menuData;
        $jsonData = json_encode($verticalMenuData);

        //this is for company menu

        foreach ( $companyMenu as $group2 ) {
            if (true) {
                $groupTitle = isset($lang) && $lang != 'en' && isset($group2->title_languages[$langId]['title']) ? $group2->title_languages[$langId]['title'] : $group2->title;
                $companyMenuData[] = [ "navheader" => $groupTitle, "slug" => $group2['slug'] ];
            }
            if (isset($group2->menu) && count($group2->menu) > 0 ) {
                $companyMenuData = $this->listSideNav2($group2->menu, $companyMenuData);
            }
        }

        $test["companyMenu"] = $companyMenuData;
        $companyMenuMenu = json_encode($test);

        // $jsonData = preg_replace('~^"?(.*?)"?$~', '$1', $jsonData);
         //dd(json_decode($jsonData));

        // Share all menuData to all the views
        \View::share('menuData', [json_decode($jsonData), $horizontalMenuData ,json_decode($companyMenuMenu)]);
    }

    public function listSideNav($data, $menuData) {

    
        foreach ($data as $value) {
            $menu = [];
            $menu["name"] = $value->title;
            $menu["id"] = $value->id;
            $menu["icon"] = $value->icon;
            $menu["slug"] = $value->slug;
            $menu["type"] = $value->type;
            $menu["show_in_sidebar"] = $value->show_in_sidebar;
            $menu["permissions"] = $value->permissions;

            if( is_array($value->permissions) && count( $value->permissions) > 0 ){
                $menu["permissions_slug"] = Permission::whereIn('id',$value->permissions)->get()->pluck('slug');
            }
            if ( count($value->child) > 0) {
                $submenuData = [];
                $menu["submenu"] = $this->listSideNav($value->child, $submenuData);
            }
            // else {
            //     $menu["url"] = $value->uri;
            // }
            $menu["url"] = $value->uri;
            $menuData[] = $menu;
        }

        return $menuData;
    }

    // public function listSideNav($data, $menuData) {

    //     foreach ($data as $value) {
    //         $menu = [];
    //         $menu["name"] = $value->title;
    //         $menu["id"] = $value->id;
    //         $menu["icon"] = $value->icon;
    //         $menu["slug"] = $value->slug;
    //         $menu["type"] = $value->type;
    //         $menu["show_in_sidebar"] = $value->show_in_sidebar;
    //         $menu["permissions"] = $value->permissions;
    //         if( is_array($value->permissions) && count( $value->permissions) > 0 ){
    //             $menu["permissions_slug"] = Permission::whereIn('id',$value->permissions)->get()->pluck('slug');
    //         }
    //         if ( count($value->child) > 0) {
    //             $submenuData = [];
    //             $menu["submenu"] = $this->listSideNav($value->child, $submenuData);
    //         }
    //         // else {
    //         //     $menu["url"] = $value->uri;
    //         // }
    //         $menu["url"] = $value->uri;
    //         $menuData[] = $menu;
    //     }

    //     return $menuData;
    // }


    public function listSideNav2($data, $menuData) {

        foreach ($data as $value) {
            $menu = [];
            $menu["name"] = $value->title;
            $menu["icon"] = $value->icon;
            $menu["id"] = $value->id;
            $menu["slug"] = $value->slug;
            $menu["permissions"] = $value->permissions;
            if( is_array($value->permissions) && count( $value->permissions) > 0 ){
                $menu["permissions_slug"] = CompanyPermission::whereIn('id',$value->permissions)->get()->pluck('slug');
            }
            if ( count($value->child) > 0) {
                $submenuData = [];
                $menu["submenu"] = $this->listSideNav($value->child, $submenuData);
            }
            else {
                $menu["url"] = $value->uri;
            }
            $menuData[] = $menu;
        }

        return $menuData;
    }
}
