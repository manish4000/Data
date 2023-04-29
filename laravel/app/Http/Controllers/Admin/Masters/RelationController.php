<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Vehicles\Relation;
use App\Models\Masters\Vehicles\SubType;
use App\Models\Masters\Vehicles\Make;
use App\Models\Masters\Vehicles\VehicleModel;
use App\Models\Masters\Vehicles\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;
use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/vehicle/relation';

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/vehicle/relation');
    }

    public function index(Request $request){

        if (!Auth::user()->can('masters-vehicle-relation')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_vehicle_relation.title'), 
        ];

        if (Auth::user()->can('masters-vehicle-relation-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = Relation::with(['type','subtype','make','vehicleModel']);  

        $types = Type::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $subtypes = SubType::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $makes = Make::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $models = VehicleModel::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();
        
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        if($request->has('type_id') && $request->input('type_id') != '') {
            $data->typeFilter($request->input('type_id')); 
        }

        if($request->has('subtype_id') && $request->input('subtype_id') != '') {
            $data->subtypeFilter($request->input('subtype_id')); 
        }

        if($request->has('make_id') && $request->input('make_id') != '') {
            $data->makeFilter($request->input('make_id')); 
        }

        if($request->has('model_id') && $request->input('model_id') != '') {
            $data->modelFilter($request->input('model_id')); 
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        
        $data = $data->paginate($perPage);

        return view('content.admin.masters.vechiles.relation.list', ['pageConfigs' => $pageConfigs,'data'=> $data, 'types'=>$types, 'subtypes'=>$subtypes, 'makes'=>$makes, 'models'=>$models, 'breadcrumbs' => $breadcrumbs,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() {

        if (!Auth::user()->can('masters-vehicle-relation-add')) {
            abort(403);
        }

        $types = Type::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $subtypes = SubType::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $makes = Make::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $models = VehicleModel::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();
  
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        return view('content.admin.masters.vechiles.relation.create-form',['menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs,'types'=>$types, 'subtypes'=>$subtypes,'makes'=>$makes,'models'=>$models ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
         
        if($request->id){
            if (!Auth::user()->can('masters-vehicle-relation-edit')) {
                abort(403);
            }
            $relation_model =   Relation::find($request->id);
        }else{
            if (!Auth::user()->can('masters-vehicle-relation-add')) {
                abort(403);
            }
            $relation_model =   new Relation;
        }

        $validator = Validator::make($request->all(),
          [
            'type_id' => 'nullable|numeric',
            'subtype_id' => 'nullable|numeric',
            'make_id' => 'nullable|numeric',
            'model_id' => 'nullable|numeric', 
          ]  ,
          [
            'type_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.type.title')  ] ),
            'subtype_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.subtype.title')  ] ),
            'make_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.make.title')  ] ),
            'model_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.model.title')  ] ),   
          ]);
    
        if ($validator->fails()){
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }
                $relation_model->type_id      =   $request->type_id;
                $relation_model->subtype_id   =   $request->subtype_id;
                $relation_model->make_id      =   $request->make_id;
                $relation_model->model_id     =   $request->model_id;
                $relation_model->is_confirmed =   isset($request->is_confirmed)? "1" : "0" ;

                if($relation_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('masters.vehicle.relation.index')->with('success_message' ,$message );
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
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {   
        if (!Auth::user()->can('masters-vehicle-relation-edit')) {
            abort(403);
        }

        $data = Relation::where('id', $id)->first();

        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        //send id as value because dynamic select work with  id as value  name as name  

        $types = Type::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $subtypes = SubType::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $makes = Make::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();

        $models = VehicleModel::select('id as value', 'name')->where('parent_id','0')->orderBy('name')->get();


        return view('content.admin.masters.vechiles.relation.create-form',['data' => $data,'types'=>$types,'subtypes'=>$subtypes,'makes'=>$makes,'models'=>$models, 'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'menuUrl' =>$this->menuUrl]);
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

    public function destroy(Request $request){

        if (!Auth::user()->can('masters-vehicle-relation-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(Relation::where('id', $request->id)->firstorfail()->delete()){
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

        if (!Auth::user()->can('masters-vehicle-relation-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(Relation::whereIn('id', $request->delete_ids)->delete()){
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

        if (!Auth::user()->can('masters-vehicle-relation-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = Relation::FindOrFail($request->id);

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
