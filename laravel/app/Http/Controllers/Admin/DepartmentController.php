<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{   

    protected $baseUrl = '';
    protected $url;
    public $menuUrl = 'admin/department';
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl = $this->url->to('admin/department');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        if (!Auth::user()->can('main-navigation-master-department')) {
            abort(403);
        }
        $data = Department::select('*');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

       
        $data = $data->paginate($perPage);
        
        $pageConfigs = [
            'moduleName' => __('webCaption.department.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        
        if(Auth::user()->can('main-navigation-master-department-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        }
        
    
        return view('content.admin.department.index',compact('data','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (!Auth::user()->can('main-navigation-master-department-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.department.create',['breadcrumbs' => $breadcrumbs ,'menuUrl' =>$this->menuUrl]);
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
            if (!Auth::user()->can('main-navigation-master-department-edit')) {
                abort(403);
            }
            $departmentModel =  Department::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-master-department-add')) {
                abort(403);
            }
            $departmentModel =  new Department;
        }
        $request->validate( 
           [
            'title' => 'required|unique:departments,title,'.$request->id.',id,deleted_at,NULL',
            'slug' => 'required|regex:/^\S*$/u|unique:departments,slug,'.$request->id.',id,deleted_at,NULL'  
           ],
           [
            'title.required' => __('webCaption.validation_required.title', ['field'=> "title" ] ) ,
            'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] )  ,
            'slug.required' => __('webCaption.validation_required.title', ['field'=> "slug" ] ) ,
            'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] )  ,
            'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
        ]);

        $departmentModel->title = $request->title;
        $departmentModel->slug = $request->slug;

        if($departmentModel->save()){
            $message = (isset($request->id)) ? $request->title ." ". __('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('department.index')->with('success_message' ,$message );
        }else{
            return redirect()->route('department.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::user()->can('main-navigation-master-department-edit')) {
            abort(403);
        }
        $data =  Department::find($id);
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
         ];

        return view('content.admin.department.create',['data' => $data,'breadcrumbs' => $breadcrumbs ,'menuUrl' =>$this->menuUrl]); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        if (!Auth::user()->can('main-navigation-master-department-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }
        
        if(Department::where('id', $request->id)->firstorfail()->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
            return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple(Request $request){

        if (!Auth::user()->can('main-navigation-master-department-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }
        
        if(Department::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }


}
