<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Models\Masters\Country;
use App\Models\SiteLanguage;
use App\Models\StateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class StateController extends Controller
{
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/common/state';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('admin/common/state');
    }

    public function index(Request $request)
    {    

        if (!Auth::user()->can('main-navigation-common-state')) {
            abort(403);
        }
        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_main_navigation_common_state.title'), 
        ];

        if (Auth::user()->can('main-navigation-common-state-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = StateModel::select('states.id','states.name','states.country_id')->with('country');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.country') && $request->input('search.country')!= null ) {
            $data->countryFilter($request->input('search.country')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $countries = Country::select('id as value','name')->orderBy('name')->get();
        $data = $data->paginate($perPage);

        return view('content.admin.masters.common.state.index', ['pageConfigs' => $pageConfigs,'countries' => $countries, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    
    public function edit($id){

        if (!Auth::user()->can('main-navigation-common-state-edit')) {
            abort(403);
        }

        $data = StateModel::with('country')->where('id', $id)->first();

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $countries = Country::select('id as value','name')->orderBy('name')->get();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        
        return view('content.admin.masters.common.state.create', ['data' => $data,'activeSiteLanguages' => $activeSiteLanguages,'countries' =>$countries,'breadcrumbs' => $breadcrumbs,'menuUrl' => $this->menuUrl]);

    }

    public function create()
    {   
        if (!Auth::user()->can('main-navigation-common-state-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_main_navigation_common_state_add.title'), 
        ];

        $countries = Country::select('id as value','name')->orderBy('name')->get();
        return view('content.admin.masters.common.state.create',['breadcrumbs' => $breadcrumbs ,'countries' => $countries,'pageConfigs' => $pageConfigs,'menuUrl' =>$this->menuUrl]);
    }


    public function store(Request $request){

        if($request->id){
            if (!Auth::user()->can('main-navigation-common-state-edit')) {
                abort(403);
            }
             $country_model =   StateModel::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-common-state-add')) {
                abort(403);
            }
             $country_model =   new StateModel;
        }
        
        $request->validate(
                [
                    'name' => 'required|max:100|unique:dash.states,name,'.$request->id.',id,deleted_at,NULL',
                    'country_id' => 'nullable|required',
                    'display' => 'required|in:Yes,No',
                ]  ,
                [   
                    'name.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
                    'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
                    'name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ,"max" => "100"] ),
                    'display.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')] ),
                    'display.in'=> __('webCaption.validation_in.title' ),
                ]                           
            );

            $country_model->name         =   $request->name;
            $country_model->country_id   =   $request->country_id;
            $country_model->display   =   $request->display;

            if($country_model->save()){
                
                $message = (isset($request->id)) ? $request->name." " .__('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title');  
                return redirect($this->baseUrl)->with(['success_message' => $message ]);
            }else{
                 return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
            }

    }



    public function destroy(Request $request){

        if (!Auth::user()->can('main-navigation-common-state-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }
        if(StateModel::where('id', $request->id)->firstorfail()->delete()){
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


        if (!Auth::user()->can('main-navigation-common-state-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(StateModel::whereIn('id', $request->delete_ids)->delete()){
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
