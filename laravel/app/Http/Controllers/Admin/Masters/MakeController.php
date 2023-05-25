<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Vehicles\Make;
use Illuminate\Http\Request;
use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;

class MakeController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseUrl      =   '';
     protected $url;
     public $menuUrl ='admin/masters/vehicle/make';
 
 
     public function __construct(UrlGenerator $url) {
         $this->url = $url;
         $this->baseUrl =  $this->url->to('/admin/masters/vehicle/make');
     }
 
     public function index(Request $request)
     {    
        
         if (!Auth::user()->can('main-navigation-masters-vehicle-make')) {
             abort(403);
         }

         $pageConfigs = [
             'baseUrl' => $this->baseUrl, 
             'moduleName' => __('webCaption.menu_main_navigation_masters_vehicle_make.title'), 
         ];
 
         if (Auth::user()->can('main-navigation-masters-vehicle-make-add')) {
             $breadcrumbs[0] = [
                 'link' => $this->baseUrl.'/add',
                 'name' => __('webCaption.add.title'), 
             ];
         }else{
             $breadcrumbs[0] = [];
         }
         
         $data = Make::withCount('children');
 
         if(  $request->has('search.keyword')) {
             $data->keywordFilter($request->input('search.keyword')); 
         }
         if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
             $data->displayStatusFilter($request->input('search.displayStatus')); 
         }   
         
        //  if(  !$request->has('search.parentOnlyShowAll')) {
             $data->parentOnlyFilter();
        // }
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

         return view('content.admin.masters.vechiles.makes.index', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
     }
 
  
 
     //send id as value because dynamic select work with  id as value  name as name  
 
     public function add() {
 
         if (!Auth::user()->can('main-navigation-masters-vehicle-make-add')) {
             abort(403);
         }
         $parent_data = Make::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
         $data = array();
         $breadcrumbs[0] = [
             'link' => $this->baseUrl,
             'name' => __('webCaption.list.title')
         ];
         return view('content.admin.masters.vechiles.makes.create',['data' => $data ,'menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs ,'parent_data' => $parent_data  ]);
     }
     
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request) {
          
         if($request->id){
             if (!Auth::user()->can('main-navigation-masters-vehicle-make-edit')) {
                 abort(403);
             }
             $make_model =   Make::find($request->id);
         }else{
             if (!Auth::user()->can('main-navigation-masters-vehicle-make-add')) {
                 abort(403);
             }
             $make_model =   new Make;
         }
 
         $validator = Validator::make($request->all(),
           [
             'display' => 'required',
             'name' => 'required|unique:dash.makes,name,'.$request->id.',id,deleted_at,NULL' 
           ]  ,
           [
             'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
             'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
             'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
           ]);
     
         if ($validator->fails()) {
             return redirect()->back()->with('errors', $validator->errors() )->withInput();
         }
 
         
 
                 $make_model->name       =   $request->name;
                 $make_model->parent_id  =   isset($request->parent_id)? $request->parent_id : 0 ;
                 $make_model->display    =   $request->display;
                 // $make_model->title_languages    =   $request->title_languages;
 
                 if($make_model->save()){
                     $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                     return redirect()->route('masters.vehicle.make.index')->with('success_message' ,$message );
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
         if (!Auth::user()->can('main-navigation-masters-vehicle-make-edit')) {
             abort(403);
         }
         $data = Make::select('id', 'name','title_languages', 'parent_id', 'display')->where('id', $id)->first();
         $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
         $breadcrumbs[0] = [
             'link' => $this->baseUrl,
             'name' => __('webCaption.list.title')
         ];   
 
         //send id as value because dynamic select work with  id as value  name as name  
         $parent_data = Make::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
         return view('content.admin.masters.vechiles.makes.create',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'parent_data' => $parent_data ,'menuUrl' =>$this->menuUrl]);
    
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
 
         if (!Auth::user()->can('main-navigation-masters-vehicle-make-delete')) {
             $result['status']     = false;
             $result['message']    = __('webCaption.alert_delete_access.title'); 
             return response()->json(['result' => $result]);
             abort(403);
         }
 
         if(Make::where('id', $request->id)->firstorfail()->delete()){
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
 
         if (!Auth::user()->can('main-navigation-masters-vehicle-make-delete')) {
             $result['status']     = false;
             $result['message']    = __('webCaption.alert_delete_access.title'); 
             return response()->json(['result' => $result]);
             abort(403);
         }
 
         if(Make::whereIn('id', $request->delete_ids)->delete()){
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


         if (!Auth::user()->can('main-navigation-masters-vehicle-make-edit')) {
             $result['status']     = false;
             $result['message']    = __('webCaption.alert_update_access.title'); 
             return response()->json(['result' => $result]);
             abort(403);
         }
 
         $__data = Make::FindOrFail($request->id);
         
         if(isset($__data->display)){
             $display =  ($__data->display == "Yes")? "No" : "Yes";
             
            if(Make::where('id',$request->id)->update(['display' => $display])){
                $result['status']     = true;
                $result['message']    = __('webCaption.alert_updated_successfully.title'); 
            }else{
                $result['status']     = false;
                $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            }
         }else{
             $result['status']     = false;
             $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
 
         }
 
 
         return response()->json(['result' => $result]);
     }
}
