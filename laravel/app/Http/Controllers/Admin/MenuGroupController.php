<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuGroup;
use Illuminate\Routing\UrlGenerator;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

use function GuzzleHttp\Promise\all;

class MenuGroupController extends Controller
{

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/menu-groups';

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/menu-groups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
            if (!Auth::user()->can('settings-menu')) {
            abort(403);
        } 

        $pageConfigs = [
            'moduleName' => __('webCaption.menu_group.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if(Auth::user()->can('settings-menu-group-add')){
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        }


        $groups = MenuGroup::select('*');

        if(  $request->has('search.keyword')) {
            $groups->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $groups->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

        $groups = $groups->paginate($perPage);
       
        return view('content.admin.menuGroup.index', compact('groups','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('settings-menu-group-add')) {
            abort(403);
        } 
        $pageConfigs = [
            'moduleName' => __('webCaption.menu_group.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $menus = Menu::where('parent_id', 0)->get();
        $activeSiteLanguages = $this->activeSiteLanguages();
        return view('content.admin.menuGroup.create', ['menus' => $menus,'pageConfigs' => $pageConfigs ,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'menuUrl' =>$this->menuUrl]);
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
            if (!Auth::user()->can('settings-menu-group-edit')) {
                abort(403);
            } 
            $group = MenuGroup::find($request->id);
        }else{
            if (!Auth::user()->can('settings-menu-group-add')) {
                abort(403);
            } 
            $group = new MenuGroup;
        }

        $request->validate([
            'title' => 'required|unique:menu_groups,title,'.$request->id,
            'order'=> 'required|numeric',
            'slug'=> 'required|regex:/^\S*$/u|unique:menu_groups,slug,'.$request->id,
        ],
        [
            'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
            'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ),
            'slug.required'=> __('webCaption.validation_required.title', ['field'=> "slug" ] ),
            'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] ),
            'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
            'order.required'=> __('webCaption.validation_required.title', ['field'=> "order" ] ),
            'order.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> "order" ] )

        ]);
        
        $group->title = $request->title;
        // $group->title_languages = $request->title_languages;
        $group->order = $request->order;
        $group->slug = $request->slug;

        if($group->save()){
            $message = (isset($request->id)) ? $request->title." ".__('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('menu-groups.index')->with(['success_message'  => $message]);
        }else{
            return redirect()->route('menu-groups.index')->with(['error_message'  => __('webCaption.alert_somthing_wrong.title')]);
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
        if (!Auth::user()->can('settings-menu-group-edit')) {
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

        $data = MenuGroup::findOrFail($id);
        return view('content.admin.menuGroup.create', ['data' => $data,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs ,'menuUrl' =>$this->menuUrl]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $user = auth()->user();
    //     if (!$user->can('update-menu-group')) {
    //         abort(403);
    //     }
    //     // dd($request->all());

    //     $validatedData = $request->validate([
    //         'title' => 'required|unique:menu_groups,title,'.$id,
    //     ],[
    //         'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
    //         'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ) 
    //     ]);

    //     $group = MenuGroup::findOrFail($id);
    //     $group->title = $request->title;
    //     $group->title_languages = $request->title_languages;
    //     $group->save();
      
    //     return redirect()->route('menu-groups.index');
    // }

    

    public function menus($id) {

        if (!Auth::user()->can('settings-menu-group-menu-list')) {
            abort(403);
        } 

        $pageConfigs = [
            'moduleName' => __('webCaption.menu.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.menu_groups.title'),
        ];

       
        // $menus = Menu::select('id', 'parent_id', 'title')->where([ 'menu_group_id' => $id, 'parent_id' => 0 ])->get();
        // $data = [];
        // foreach ( $menus as $value ) {
        //     $value['level'] = 1;
        //     $data[] = $value;

        //     if (count($value->child) > 0) {
        //         foreach($value->child as $child) {
        //             $child['level'] = 2;
        //             $data[] = $child;
        //         }
        //     }
        // }
        $data = [];
        $menuOrderData = $this->orderMenuData(0, 1, $data, $id);
        $data = $menuOrderData;
        
          
        $menu_group = MenuGroup::find($id);

        $permissions = Permission::where('parent_id', 0)->get();
        $arrayData = [];
        $permissionData = $this->listSelectableTreeData($permissions, $arrayData);

        $menusWithoutParent = Menu::where([ 'menu_group_id' => $id, 'parent_id' => 0 ])->get();
       
        $selectableMenuData = $this->listSelectableMenuData($menusWithoutParent, $arrayData);

        $activeSiteLanguages = $this->activeSiteLanguages();
            

        return view('content.admin.menuGroup.listMenu', ['menu_group' => $menu_group,'breadcrumbs' => $breadcrumbs,'pageConfigs' => $pageConfigs,'data' => $data, 'permissionData' => $permissionData, 'activeSiteLanguages' => $activeSiteLanguages, 'selectableMenuData' => $selectableMenuData ,'menuUrl' =>$this->menuUrl]);
    }

    //addMenu and updateMenu with single method  

    public function addMenu(Request $request)
    {   
      
        // if (!Auth::user()->can('menu-group-add')) {
        //     abort(403);
        // } 

        $request->validate(
            [
                'title' => 'required',
                'slug' => 'required_if:type,==,menu|nullable|sometimes|unique:menu',
                'icon' => 'required_if:type,==,menu',
                'uri' => 'required_if:type,==,menu',
                'permission_slug' =>'required|regex:/^\S*$/u|unique:menu',
                'type' =>'required|in:permission,menu',
                'order' => 'nullable|numeric',
            ],
            [
                'title.required' => __('webCaption.validation_required.title', ['field'=> "title" ] ),
                'permission_slug.required' => __('webCaption.validation_required.title', ['field'=> "permission slug" ] ),
                'permission_slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('permission_slug')] )  ,
                'permission_slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(-)" ]  ),
                'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] )  ,
                'slug.required_if' => __('webCaption.validation_required.title', ['field'=> 'Slug' ] )  ,
                'icon.required_if' => __('webCaption.validation_required.title', ['field'=> 'Icon' ] )  ,
                'uri.required_if' => __('webCaption.validation_required.title', ['field'=> 'Uri' ] )  ,
                'type.in' => __('webCaption.validation_in.title', ['field'=> "Type" ] ),
                'type.required' => __('webCaption.validation_required.title', ['field'=> "Type" ] ),
                'order.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Order" ] ),

            ]
         );

        $menu = new Menu;
        $menu->title = $request->title;
        $menu->slug= $request->slug;
        $menu->uri = $request->uri;
        $menu->icon = $request->icon;
        $menu->permission_slug = $request->permission_slug;
        $menu->type = $request->type;
        $menu->order = isset($request->order)? $request->order : 0 ;
        $menu->menu_group_id = $request->menu_group_id;
        $menu->permissions = $request->items;
        $menu->parent_id = isset($request->item_id) ? $request->item_id : 0;

        // $menu->title_languages = $request->title_languages;

        if($menu->save()){
            return redirect()->route('menu-groups.menus', $menu->menu_group_id )->with(['success_message' => $request->title." ".__('webCaption.alert_added_successfully.title')]);
        }else{
            return redirect()->route('menu-groups.menus', $menu->menu_group_id )->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
        }      
    }


    function makeTree($arr=[]) 

        {   
                $tree=[];
                
                foreach($arr as $item) {

                    $child_lev_2  = Menu::with('menuChild')->where('id',$item['id'])->first()->toArray();
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

    public function updateMenu(Request $request, $id) {

        // $user = auth()->user();
        // if (!$user->can('update-menu')) {
        //     abort(403);
        // }

        //this code for get ids of all childs of given id 
        $menu =  Menu::with('menuChild')->select('id','title')->find($id)->toArray();
        $child_ids =  $this->makeTree($menu['menu_child']) ;
        $child_ids =   $this->array_flatten($child_ids);
        //end code 

        $request->validate([
            'menu_group_id' => 'required',
            'title' => 'required',
            'order' => 'nullable|numeric',
            'permission_slug' =>'required|regex:/^\S*$/u|unique:menu,permission_slug,'.$request->id,
            'type' =>'required|in:permission,menu',
            'uri' => 'required_if:type,==,menu',
            'slug' => 'required_if:type,==,menu|nullable|sometimes|regex:/^\S*$/u|unique:menu,slug,'.$request->id,
            'icon' => 'required_if:type,==,menu',
        ],[
            'menu_group_id.required' => __('webCaption.validation_required.title', ['field'=> "menu Group" ] ),
            'title.required' => __('webCaption.validation_required.title', ['field'=> "Title" ] ),
            'permission_slug.required' => __('webCaption.validation_required.title', ['field'=> "Permission Slug" ] ),
            'permission_slug.regex' => __('webCaption.validation_space.title', ['field'=> "Permission Slug" ,"use" => "(-)" ]  ),
            'type.required' => __('webCaption.validation_required.title', ['field'=> "Type"]),
            'permission_slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('permission_slug')] )  ,
            'order.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Order" ] ),
            'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] )  ,
            'slug.required_if' => __('webCaption.validation_required.title', ['field'=> 'Slug' ] )  ,
            'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
            'icon.required_if' => __('webCaption.validation_required.title', ['field'=> 'Icon' ] )  ,
            'uri.required_if' => __('webCaption.validation_required.title', ['field'=> 'Uri' ] )  ,
            'type.in' => __('webCaption.validation_in.title', ['field'=> "Type" ] ),
        ]);

        $menu = Menu::findOrFail($id);
        $menu->title = $request->title;
        $menu->slug = $request->slug;
        $menu->uri = $request->uri;
        $menu->icon = $request->icon;
        $menu->permission_slug = $request->permission_slug;
        $menu->type = $request->type;
        $menu->menu_group_id = $request->menu_group_id;
        $menu->permissions = $request->items;
        $menu->order = isset($request->order)? $request->order : 0 ;
        $menu->parent_id = isset($request->item_id) ? $request->item_id : 0;
        // $menu->title_languages = $request->title_languages;

        if($menu->save()){

            $menu->whereIn('id',$child_ids)->update(['menu_group_id' => $request->menu_group_id]);

            return redirect()->route('menu-groups.menus', $menu->menu_group_id )->with(['success_message' => $request->title." ". __('webCaption.alert_updated_successfully.title')]);
        }else{
            return redirect()->route('menu-groups.menus', $menu->menu_group_id )->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
        }  
    }

    public function editMenu($id) {
        // $user = auth()->user();
        // if (!$user->can('update-menu')) {
        //     abort(403);
        // }

        $pageConfigs = [
            'moduleName' => __('webCaption.menu_group.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $menu = Menu::find($id);

        $breadcrumbs[0] = [
            'link' => $this->baseUrl.'/'.$menu->menu_group_id.'/menus',
            'name' => 'List'
        ]; 

        $menuList = Menu::select('id','title')->where(['parent_id' => 0, 'menu_group_id' => $menu->menu_group_id])->get();

        $groups = MenuGroup::select('id as value','title as name')->get();
        
        $permissions = Permission::where('parent_id', 0)->get();
        $arrayData = [];
        $permissionData = $this->listSelectableTreeData($permissions, $arrayData);

        $selectableMenuData = $this->listSelectableMenuData($menuList, $arrayData);

        $activeSiteLanguages = $this->activeSiteLanguages();

        return view('content.admin.menuGroup.editMenu', ['menu' => $menu ,'selectableMenuData' => $selectableMenuData ,'menuList' =>$menuList , 'groups' => $groups , 'permissionData' => $permissionData , 'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
    }



    public function destroyMenu(Request $request)
    {   
        $user = Auth::user();
        // if (!$user->can('soft-delete-menu')) {
        //     abort(403);
        // }
        // dd($id);
        $menu = Menu::find($request->id);
        
        if($menu->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
        

        // $menuGroupId = $menu->menu_group_id;
        // $delete = $menu->delete();
        // return redirect()->route('menu-groups.menus', $menuGroupId);
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {       
        if (!Auth::user()->can('settings-menu-group-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }         
        if(MenuGroup::where('id', $request->id)->firstorfail()->delete()){
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

        $menu = Menu::find($id);
        $menu->parent_id = $parent_id;
        if($menu->save()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_updated_successfully.title'); 
            return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);     
        } 
    }

    private function activeSiteLanguages() {
        $activeSiteLanguages = \App\Models\SiteLanguage::where('status', 'Active')->get();

        return $activeSiteLanguages;
    }

    public function orderMenuData($parent_id, $level, &$data, $menu_group_id) {
        $menus = Menu::where([ 'menu_group_id' => $menu_group_id, 'parent_id' => $parent_id ])->get();
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
