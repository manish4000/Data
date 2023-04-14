<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyMenuGroup;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyModule;
use App\Models\Company\CompanyPermission;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuGroupController extends Controller
{
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl = 'admin/company/menu-groups';

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/company/menu-groups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {   
        if (!Auth::user()->can('main-navigation-company-menu-group')) {
            abort(403);
        } 

        $pageConfigs = [
            'moduleName' => __('webCaption.company_menu_groups.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::user()->can('main-navigation-company-menu-group-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        } 
        
        $groups = CompanyMenuGroup::select('*');
        if($request->has('search.keyword')){
            $groups->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $groups->orderBy($request->order_by, $request->order);
        }
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $groups = $groups->paginate($perPage);

        return view('content.admin.company.menuGroup.index', compact('groups','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('main-navigation-company-menu-group-add')) {
            abort(403);
        }
        $pageConfigs = [
            'moduleName' => __('webCaption.company_menu_group_add.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $menus = CompanyMenuGroupMenu::where('parent_id', 0)->get();
        return view('content.admin.company.menuGroup.create', ['menus' => $menus, 'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if($request->id){
            if (!Auth::user()->can('main-navigation-company-menu-group-edit')) {
                abort(403);
            }
            $group = CompanyMenuGroup::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-company-menu-group-add')) {
                abort(403);
            }
            $group = new CompanyMenuGroup;
        }

        $request->validate([
            'title' => 'required|unique:company_menu_groups,title,'.$request->id.',id,deleted_at,NULL',
            'order'=> 'nullable|numeric',
            'slug' => 'required|string|regex:/^\S*$/u|unique:company_menu_groups,slug,'.$request->id.',id,deleted_at,NULL'
        ],
        [
            'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
            'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ),
            'slug.required'=> __('webCaption.validation_required.title', ['field'=> "slug" ] ),
            'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] ),
            'slug.string' => __('webCaption.validation_string.title', ['field'=> $request->input('slug')] ),
            'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
            'order.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> "order" ] )
        ]);

        
        $group->title = $request->title;
        $group->order = isset($request->order)?$request->order :'0';
        $group->slug = $request->slug;

        if($group->save()){
            $message = (isset($request->id)) ? $request->title ." ". __('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title') ;
             return redirect()->route('company.menu-groups.index')->with(['success_message'  => $message]);
            }else{
             return redirect()->route('company.menu-groups.index')->with(['error_message'  => __('webCaption.alert_somthing_wrong.title')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = auth()->user();
        // if (!$user->can('update-menu-group')) {
        //     abort(403);
        // }
        if (!Auth::user()->can('main-navigation-company-menu-group-edit')) {
            abort(403);
        }
        $pageConfigs = [
            'moduleName' => __('webCaption.menu_group.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title'),
        ];

        $data = CompanyMenuGroup::findOrFail($id);
        return view('content.admin.company.menuGroup.create', ['data' => $data, 'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs, 'menuUrl' => $this->menuUrl]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function menus($id) {

        if (!Auth::user()->can('main-navigation-company-menu-group-listmenu')) {
            abort(403);
        }

        $pageConfigs = [
            'moduleName' => __('webCaption.company_menu_groups.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title'),
        ];

        $data = [];
        $menuOrderData = $this->orderMenuData(0, 1, $data, $id);
        $data = $menuOrderData;
        $menu_group = CompanyMenuGroup::find($id);
        $permissions = CompanyPermission::where('parent_id', 0)->get();
        $arrayData = [];
        $permissionData = $this->listSelectableTreeData($permissions, $arrayData);
        $menusWithoutParent = CompanyMenuGroupMenu::where([ 'company_menu_group_id' => $id, 'parent_id' => 0 ])->get();
        $selectableMenuData = $this->listSelectableMenuData($menusWithoutParent, $arrayData);
        $modules = CompanyModule::select('id as value' ,'title as name')->get();

        return view('content.admin.company.menuGroup.listMenu', ['breadcrumbs'=>$breadcrumbs,'menuGroupId' => $id,'pageConfigs' => $pageConfigs,'menu_group' => $menu_group,'modules' => $modules,'data' => $data, 'permissionData' => $permissionData, 'selectableMenuData' => $selectableMenuData ,'menuUrl' => $this->menuUrl]);
    }

            function makeTree($arr=[]) 

            {   
                $tree=[];
                
                foreach($arr as $item) {

                    $child_lev_2  = CompanyMenuGroupMenu::with('menuChild')->where('id',$item['id'])->first()->toArray();
                    array_push($tree,$item['id']);
                    
                    if(count($child_lev_2['menu_child']) > 0) {
                        $item =  $this->makeTree($child_lev_2['menu_child']);
                        array_push($tree ,$item);
                    }
                }
                        return $tree;
            }

        function array_flatten($array)
            {
                $result = [];
                foreach ($array as $element) {
                if (is_array($element)) {
                    $result = array_merge($result, $this->array_flatten($element));
                } else {
                    $result[] = $element;
                }
                }
                return $result;
            }






    //addMenu and updateMenu with single method  

    public function addMenu(Request $request)
    {       
     

       // if (!Auth::user()->can('menu-group-add')) {
        //     abort(403);
        // } 

        $request->validate(
            [
                'title' => 'required|string',
                // 'title' => 'required|string|unique:company_menu_groups_menu,title,'.$request->id.',id,deleted_at,NULL',
                'slug' => 'required_if:type,==,menu|nullable|sometimes|regex:/^\S*$/u|unique:company_menu_groups_menu,slug,'.$request->id,
                'icon' => 'required_if:type,==,menu',
                'uri' => 'required_if:type,==,menu',
                'company_menu_group_id' => 'required',
                'permission_slug' =>'required|regex:/^\S*$/u|unique:company_menu_groups_menu,permission_slug,'.$request->id,
                'type' =>'required|in:permission,menu',
                'order' => 'nullable|numeric',
            ],
            [
                'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
                'slug.required_if'=> __('webCaption.validation_required.title', ['field'=> "Slug" ] ),
                // 'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ) ,
                'title.string' => __('webCaption.validation_string.title', ['field'=> $request->input('title')] ) ,
                'uri.required'=> __('webCaption.validation_required.title', ['field'=> "uri" ] ),
                'icon.required_if'=> __('webCaption.validation_required.title', ['field'=> "Icon" ] ),
                'uri.required_if'=> __('webCaption.validation_required.title', ['field'=> "Uri" ] ),
                'company_menu_group_id.required'=> __('webCaption.validation_required.title', ['field'=> "company_menu_group_id" ] ),
                'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] )  ,
                'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
                'permission_slug.required' => __('webCaption.validation_required.title', ['field'=> "permission slug" ] ),
                'permission_slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('permission_slug')] )  ,
                // 'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] ),
                'type.required' => __('webCaption.validation_required.title', ['field'=> "Type" ] ),
                'type.in' => __('webCaption.validation_in.title', ['field'=> "Type" ] ),
            ]
        );

        if($request->id){
            $menu = CompanyMenuGroupMenu::findOrFail($request->id);
            
             //this code for get ids of all childs of given id 
             $menudata =  CompanyMenuGroupMenu::with('menuChild')->select('id','title')->find($request->id)->toArray();
             $child_ids =  $this->makeTree($menudata['menu_child']) ;
             $child_ids =   $this->array_flatten($child_ids);
             //end code  
        }else{
            $menu = new CompanyMenuGroupMenu;
        } 


      
        $menu->title = $request->title;
        $menu->slug= $request->slug;
        $menu->uri = $request->uri;
        $menu->icon = $request->icon;
        $menu->permission_slug = $request->permission_slug;
        $menu->type = $request->type;
        $menu->order = isset($request->order)? $request->order : 0 ;
        $menu->company_menu_group_id = $request->company_menu_group_id;
        $menu->permissions = $request->items;
        $menu->company_module_id = $request->company_module_id;
        $menu->parent_id = isset($request->item_id) ? $request->item_id : 0;

        if($menu->save()){

            if($request->id){

                $menu->whereIn('id',$child_ids)->update(['company_menu_group_id' => $request->company_menu_group_id]);

                return redirect()->route('company.menu-groups.menus', $menu->company_menu_group_id )->with(['success_message' => $request->title." ".__('webCaption.alert_updated_successfully.title')]);
            }else{

                return redirect()->route('company.menu-groups.menus', $menu->company_menu_group_id )->with(['success_message' => $request->title." ".__('webCaption.alert_added_successfully.title')]);
            }

        }else{
            return redirect()->route('company.menu-groups.menus', $menu->company_menu_group_id )->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
        }      
    }
    public function updateMenu(Request $request, $id) {
        // $user = auth()->user();
        // if (!$user->can('update-menu')) {
        //     abort(403);
        // }

        $request->validate(
            [
                // 'title' => 'required|string|unique:company_menu_groups_menu,title,'.$id.',id,deleted_at,NULL',
                'title' => 'required|string',
                'icon' => 'required_if:type,==,menu',
                'uri' => 'required_if:type,==,menu',
                'company_menu_group_id' => 'required',
                'slug' => 'required_if:type,==,menu|nullable|sometimes|regex:/^\S*$/u|unique:company_menu_groups_menu,slug,'.$id.',id,deleted_at,NULL',
                'permission_slug' =>'required|unique:menu',
                'type' =>'required|in:permission,menu'
            ],
            [
                'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
                // 'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ) ,
                'title.string' => __('webCaption.validation_string.title', ['field'=> $request->input('title')] ) ,
                'uri.required'=> __('webCaption.validation_required.title', ['field'=> "uri" ] ),
                'icon.required_if'=> __('webCaption.validation_required.title', ['field'=> "Icon" ] ),
                'uri.required_if'=> __('webCaption.validation_required.title', ['field'=> "Uri" ] ),
                'company_menu_group_id.required'=> __('webCaption.validation_required.title', ['field'=> "company_menu_group_id" ] ),
                'slug.required'=> __('webCaption.validation_required.title', ['field'=> "slug" ]), 
                'slug.string'=> __('webCaption.validation_string.title', ['field'=> "slug" ]), 
                'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
                'slug.required_if'=> __('webCaption.validation_required.title', ['field'=> "Slug" ] ),
                // 'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] ),
                'type.required' => __('webCaption.validation_required.title', ['field'=> "Type" ] ),
                'type.in' => __('webCaption.validation_in.title', ['field'=> "Type" ] ),
                'permission_slug.required' => __('webCaption.validation_required.title', ['field'=> "permission slug" ] ),
                'permission_slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('permission_slug')] )  ,
            ]
        );

        $menu = CompanyMenuGroupMenu::findOrFail($id);
        $menu->title = $request->title;
        $menu->slug = $request->slug;
        $menu->uri = $request->uri;
        $menu->icon = $request->icon;
        $menu->permission_slug = $request->permission_slug;
        $menu->type = $request->type;
        $menu->company_menu_group_id = $request->company_menu_group_id;
        $menu->permissions = $request->items;
        $menu->order = isset($request->order)? $request->order : 0 ;
        $menu->company_module_id = $request->company_module_id;
        $menu->parent_id = isset($request->item_id) ? $request->item_id : 0;

        if($menu->save()){
            return redirect()->route('company.menu-groups.menus', $menu->company_menu_group_id )->with(['success_message' => $request->title." ". __('webCaption.alert_updated_successfully.title')]);
        }else{
            return redirect()->route('company.menu-groups.menus', $menu->company_menu_group_id )->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
        }  
    }

    public function editMenu($id) {

        // $user = auth()->user();
        // if (!$user->can('update-menu')) {
        //     abort(403);
        // }
        
        $pageConfigs = [
            'moduleName' => __('webCaption.company_menu_group.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $menu = CompanyMenuGroupMenu::find($id);
        $breadcrumbs[0] = [
            'link' => $this->baseUrl.'/'.$menu->company_menu_group_id.'/menus',
            'name' => 'List'
        ]; 

        $data = [];
        $menuOrderData = $this->orderMenuData(0, 1, $data, $menu->company_menu_group_id);
        $data = $menuOrderData;

        $menuList = CompanyMenuGroupMenu::select('id','title')->where(['parent_id' => 0, 'company_menu_group_id' => $menu->company_menu_group_id])->get();

        $groups = CompanyMenuGroup::select('id as value','title as name')->get();
        $permissions = CompanyPermission::where('parent_id', 0)->get();
        $arrayData = [];
        $permissionData = $this->listSelectableTreeData($permissions, $arrayData);
        $selectableMenuData = $this->listSelectableMenuData($menuList, $arrayData);
        $modules = CompanyModule::select('id as value' ,'title as name')->get();


        return view('content.admin.company.menuGroup.listMenu', ['data' => $data,'menu' => $menu,'menuGroupId' => $menu->menu_group_id,'modules' => $modules, 'selectableMenuData' => $selectableMenuData,'menuList' => $menuList, 'groups' => $groups, 'permissionData' => $permissionData,'pageConfigs' => $pageConfigs ,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
    }



    public function destroyMenu(Request $request)
    {   
        
        $user = Auth::user();
        // if (!$user->can('soft-delete-menu')) {
        //     abort(403);
        // }

        $menu = CompanyMenuGroupMenu::find($request->id);
        if($menu->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {              
        if (!Auth::user()->can('main-navigation-company-menu-group-delete')) {
            abort(403);
        }
        if(CompanyMenuGroup::where('id', $request->id)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }  
    }

    public function deleteMultiple(Request $request)
    {              
        if (!Auth::user()->can('main-navigation-company-menu-group-delete')) {
            abort(403);
        }
        if(CompanyMenuGroup::whereIn('id',$request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }  
    }


    public function listSelectableTreeData($items, $arrayData) {
        foreach ($items as $item) {
            $item['title'] = $item->name;
            $item['value'] = $item->id;
            $arrayData[] = $item;

            if ( count($item->child) > 0) {
                $item['subs'] = $item->child;
                $this->listSelectableTreeData($item['subs'], $arrayData);
            }
        }
        return $arrayData;
    }

    public function listSelectableMenuData($items, $arrayData) {
        foreach ($items as $item) {
            $item['value'] = $item->id;
            $arrayData[] = $item;

            if ( count($item->child) > 0) {
                $item['subs'] = $item->child;
                $this->listSelectableMenuData($item['subs'], $arrayData);
            }
        }
        return $arrayData;
    }

    public function updateMenuPosition(Request $request) {

        $id = $request->id;
        $parent_id = $request->parent;
        $menu = CompanyMenuGroupMenu::find($id);
        $menu->parent_id = $parent_id;

        if($menu->save()){
            $result['status']     = true;
            $result['message']    =__('webCaption.alert_updated_successfully.title'); 
            return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);     
        } 
    }


    public function orderMenuData($parent_id, $level, &$data, $menu_group_id) {
        $menus = CompanyMenuGroupMenu::where([ 'company_menu_group_id' => $menu_group_id, 'parent_id' => $parent_id ])->get();
        foreach ($menus as $menu) {
            $menu['level'] = $level;
            $menu['title'] = $menu->title;
            $data[] = $menu;

            if (count($menu->menuChild) > 0) {
                $this->orderMenuData($menu->id, $level+1, $data, $menu_group_id);
            }
        }
        return $data;
    }
}
