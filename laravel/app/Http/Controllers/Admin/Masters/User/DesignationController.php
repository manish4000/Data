<?php

namespace App\Http\Controllers\Admin\Masters\User;

use App\Http\Controllers\Controller;
use App\Models\Masters\User\Designation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/user/designation';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/user/designation');
    }

    public function index(Request $request)
    {    
        if (!Auth::user()->can('masters-user-designation')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_user_designation.title'), 
        ];

        if (Auth::user()->can('masters-user-designation-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = Designation::withCount('children');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
            $data->displayStatusFilter($request->input('search.displayStatus')); 
        }   
        
       // if(  !$request->has('search.parentOnlyShowAll')) {
            $data->parentOnlyFilter();
        //}
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $data->with(['children'=>function($query) use ($request) {
            if(  $request->has('search.keyword')) {
                $query->keywordFilter($request->input('search.keyword')); 
            }
            if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
                $query->displayStatusFilter($request->input('search.displayStatus')); 
            }

            if($request->has('order_by') != "children_count"){
                
                if($request->has('order_by') &&  $request->has('order') ){
                    $query->orderBy($request->order_by, $request->order);
                }
            }

        } ]); 

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        return view('content.admin.masters.user.designation.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() {

        if (!Auth::user()->can('masters-user-designation-add')) {
            abort(403);
        }
        $parent_data = Designation::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        $data = array();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.masters.user.designation.create-form',['data' => $data ,'menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs ,'parent_data' => $parent_data  ]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         
        if($request->id){
            if (!Auth::user()->can('masters-user-designation-edit')) {
                abort(403);
            }
            $designation_model =   Designation::find($request->id);
        }else{
            if (!Auth::user()->can('masters-user-designation-add')) {
                abort(403);
            }
            $designation_model =   new Designation;
        }

        $validator = Validator::make($request->all(),
          [
            'display' => 'required',
            'name' => 'required|unique:designation,name,'.$request->id.',id,deleted_at,NULL' 
          ]  ,
          [
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
            'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
            'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
          ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

        

                $designation_model->name       =   $request->name;
                $designation_model->parent_id  =   isset($request->parent_id)? $request->parent_id : 0 ;
                $designation_model->display    =   $request->display;
                // $designation_model->title_languages    =   $request->title_languages;

                if($designation_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('masters.user.designation.index')->with('success_message' ,$message );
                }else{
                    return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::user()->can('masters-user-designation-edit')) {
            abort(403);
        }
        $data = Designation::select('id', 'name','title_languages', 'parent_id', 'display')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        //send id as value because dynamic select work with  id as value  name as name  
        $parent_data = Designation::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        return view('content.admin.masters.user.designation.create-form',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'parent_data' => $parent_data ,'menuUrl' =>$this->menuUrl]);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {

        if (!Auth::user()->can('masters-user-designation-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(Designation::where('id', $request->id)->firstorfail()->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
        
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple( Request $request){

        if (!Auth::user()->can('masters-user-designation-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(Designation::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }

        
    }


    public function updateStatus(Request $request){

        
        if (!Auth::user()->can('masters-user-designation-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = Designation::FindOrFail($request->id);

        if(isset($__data->display)){
            $display =  ($__data->display == "Yes")? "No" : "Yes";
            // $__data->display = $display;
            $__data->update(['display' => $display]);  
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_updated_successfully.title'); 
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 

        }


        return response()->json(['result' => $result]);
    }
}
