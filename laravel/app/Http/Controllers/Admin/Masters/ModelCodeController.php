<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;
use App\Models\Masters\Vehicles\VehicleModel;
use App\Models\Masters\Vehicles\ModelCode;
use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class ModelCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/vehicle/model-code';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/vehicle/model-code');
    }

    public function index(Request $request)
    {    

        if (!Auth::user()->can('masters-vehicle-model-code')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_vehicle_model_code.title'), 
        ];

        if (Auth::user()->can('masters-vehicle-model-code-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = ModelCode::withCount('children')->with('model_name');
        
        if($request->has('search.model') && $request->input('search.model') != '') {
            
            $data->modelFilter($request->input('search.model')); 
        }

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
        $allmodel = VehicleModel::select('id as value','name')->orderBy('name')->get();

        
        return view('content.admin.masters.vechiles.model_code.list', ['allmodel' => $allmodel,'pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() 
    {
        if (!Auth::user()->can('masters-vehicle-model-code-add')) {
            abort(403);
        }
        $parent_data = ModelCode::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        $allmodel = VehicleModel::select('id as value','name')->orderBy('name')->get();
        $data = array();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.masters.vechiles.model_code.create-form',['allmodel' => $allmodel,'data' => $data ,'menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs ,'parent_data' => $parent_data  ]);
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
            if (!Auth::user()->can('masters-vehicle-model-code-edit')) {
                abort(403);
            }
            $model_code_model =   ModelCode::find($request->id);
        }else{
            if (!Auth::user()->can('masters-vehicle-model-code-add')) {
                abort(403);
            }
            $model_code_model =   new ModelCode;
        }

        $validator = Validator::make($request->all(),
        [
        'display' => 'required',
        'name' => 'required|unique:model_code,name,'.$request->id.',id,deleted_at,NULL', 
        'model_id' => 'required|numeric', 
        ]  ,
        [
        'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
        'model_id.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.type.title') .' '.__('webCaption.id.title')  ] ),
        'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
        'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

        $model_code_model->name        =   $request->name;
        $model_code_model->parent_id   =   isset($request->parent_id)? $request->parent_id : 0 ;
        $model_code_model->model_id    =   $request->model_id;
        $model_code_model->display     =   $request->display;
        $model_code_model->length      =   $request->length;
        $model_code_model->width       =   $request->width;
        $model_code_model->height      =   $request->height;
        // $model_code_model->title_languages    =   $request->title_languages;
        
        if($model_code_model->save()){
            $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('masters.vehicle.model-code.index')->with('success_message' ,$message );
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
        if (!Auth::user()->can('masters-vehicle-model-code-edit')) {
            abort(403);
        }
        $data = ModelCode::select('id', 'name','title_languages', 'parent_id', 'display', 'model_id', 'length', 'width', 'height')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        //send id as value because dynamic select work with  id as value  name as name  
        $parent_data = ModelCode::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        $allmodel = VehicleModel::select('id as value','name')->orderBy('name')->get();

        return view('content.admin.masters.vechiles.model_code.create-form',['allmodel' => $allmodel,'data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'parent_data' => $parent_data ,'menuUrl' =>$this->menuUrl]);
   
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
    public function destroy(Request $request) 
    {
        if (!Auth::user()->can('masters-vehicle-model-code-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(ModelCode::where('id', $request->id)->firstorfail()->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
        
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple( Request $request)
    {
        if (!Auth::user()->can('masters-vehicle-model-code-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(ModelCode::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
  
    }

    public function updateStatus(Request $request)
    {

        if (!Auth::user()->can('masters-vehicle-model-code-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = ModelCode::FindOrFail($request->id);

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