<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyModule;
use App\Models\Company\CompanyPermission;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PermissionController extends Controller
{
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl = 'admin/company/permission';

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/company/permission');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $permissionData = $this->orderPermission(0, 1, $data);
        $data = $permissionData;
        
        $permissions = CompanyPermission::where('parent_id', 0)->get();
        $arrayData = [];
        $listPermission = $this->listPermission($permissions, $arrayData);
        $permissions = $listPermission;
        $modules = CompanyModule::select('id as value' ,'title as name')->get();
       return view('content.admin.company.permission.index',['permissions' => $permissions,'data' => $data,'modules' => $modules ]);
    }

    public function orderPermission($parent_id, $level, &$data) {
        $permissions = CompanyPermission::where('parent_id', $parent_id)->get();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request['slug'] = Str::slug($request->slug);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:company_permissions,slug,'.$request->id,
        ],
        [
            'name.required' => __('webCaption.validation_required.title', ['field'=> "name" ] ),
            'slug.required' => __('webCaption.validation_required.title', ['field'=> "slug" ] ),
            'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] ),
        ]);

        if(isset($request->id)){
           $permission = CompanyPermission::find($request->id);
        }else{
            $permission = new CompanyPermission;
        }
        $permission->name = $request->name;
        $permission->slug = $request->slug;
        $permission->company_module_id = $request->company_module_id;
        $permission->parent_id = isset($request->permission_id) ? $request->permission_id : 0;

        if($permission->save()){
            $message = (isset($request->id)) ? $request->name ." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('company.permission.index')->with('success_message' ,$message );
        }else{
            return redirect()->route('company.permission.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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

    public function updateCompanyPermissionPosition(Request $request) {
        $id = $request->id;
        $parent_id = $request->parent;
        $permission = CompanyPermission::find($id);
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        $permission = CompanyPermission::find($id);
        $permissions = CompanyPermission::where('parent_id', 0)->get();
        $arrayData = [];
        $listPermission = $this->listPermission($permissions, $arrayData);
        $permissions = $listPermission;
        $modules = CompanyModule::select('id as value' ,'title as name')->get();
        return view('content.admin.company.permission.edit',['permission' => $permission,'modules' => $modules,'permissions' => $permissions,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // if (!Auth::user()->can('masters-vehicle-type-delete')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_delete_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

        if(CompanyPermission::where('id', $request->id)->firstorfail()->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
           return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }
}
