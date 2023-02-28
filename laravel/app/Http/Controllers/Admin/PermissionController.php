<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/permissions';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/permissions');
    }




    public function index()
    {
        $user = auth()->user();
        if (!$user->can('settings-permissions')) {
            abort(403);
        }

        $pageConfigs = [
            'moduleName' => __('webCaption.permission.title'), 
        ];

        $data = [];
        $permissionData = $this->orderPermission(0, 1, $data);
        $data = $permissionData;

        $permissions = Permission::where('parent_id', 0)->get();
        $arrayData = [];
        $listPermission = $this->listPermission($permissions, $arrayData);
        
        $permissions = $listPermission;
        return view('content.admin.permission.index',['data' =>$data, 'pageConfigs' => $pageConfigs,'permissions' => $permissions ,'menuUrl' =>$this->menuUrl]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->can('settings-permissions-add')) {
            abort(403);
        }
        $request['slug'] = Str::slug($request->slug);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permissions',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->slug = $request->slug;
        $permission->parent_id = isset($request->permission_id) ? $request->permission_id : 0;
        $permission->save();
        
        if($permission->save()){
            return redirect()->back()->with(['success_message' => $request->name." ".__('webCaption.alert_added_successfully.title')]);
        }else{
            return redirect()->back()->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
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
        if (!Auth::user()->can('settings-permissions-edit')) {
            abort(403);
        }
        $pageConfigs = [
            'moduleName' => __('webCaption.permission.title'), 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title'), 
        ];
        $permission = Permission::find($id);

        $permissions = Permission::where('parent_id', 0)->get();
        $arrayData = [];
        $listPermission = $this->listPermission($permissions, $arrayData);
        
        $permissions = $listPermission;
        return view('content.admin.permission.edit', ['permission' => $permission ,'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs,'permissions' => $permissions,'menuUrl' => $this->menuUrl]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('settings-permissions-edit')) {
            abort(403);
        }

        $request['slug'] = Str::slug($request->slug);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permissions,slug,'.$id,
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->slug = $request->slug;
        $permission->parent_id = isset($request->permission_id) ? $request->permission_id : 0;
        $permission->save();

        if($permission->save()){
            return redirect()->route('permissions.index')->with(['success_message' => $request->name." ". __('webCaption.alert_updated_successfully.title')]);
        }else{
            return redirect()->route('permissions.index')->with(['error_message' =>  __('webCaption.alert_somthing_wrong.title')]);
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
        if (!Auth::user()->can('settings-permissions-delete')) {
            abort(403);
        }

        $permission = Permission::find($request->id);
        
        if($permission->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function updatePermissionPosition(Request $request) {

        if (!Auth::user()->can('settings-permissions-edit')) {
            abort(403);
        }

        $id = $request->id;
        $parent_id = $request->parent;
        $permission = Permission::find($id);
        $permission->parent_id = $parent_id;
        if($permission->save()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_updated_successfully.title'); 
            return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);     
        } 
    }

    // public function getLevel($permission, $level) {
    //     $parent = $permission->parent;
    //     if ($parent->parent_id != 0) {
    //         $level++;
    //     }
    //     return $level;
    // }

    public function orderPermission($parent_id, $level, &$data) {
        $permissions = Permission::where('parent_id', $parent_id)->get();

        foreach ($permissions as $permission) {
            $permission['level'] = $level;
            $permission['title'] = $permission->name;
            $data[] = $permission;

            if (count($permission->child) > 0) {
                $this->orderPermission($permission->id, $level+1, $data);
            }
        }

        return $data;
    }

    public function listPermission($permissions, $arrayData) {

        foreach ($permissions as $permission) {
            $permission['title'] = $permission->name;
            $arrayData[] = $permission;
            if ( count($permission->child) > 0) {
                $permission['subs'] = $permission->child;
                $this->listPermission($permission['subs'], $arrayData);
            }
        }
        return $arrayData;
    }
}
