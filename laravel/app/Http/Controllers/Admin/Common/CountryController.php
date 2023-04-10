<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Models\Masters\Country;
use App\Models\RegionModel;
use Illuminate\Http\Request;
use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class CountryController extends Controller
{
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/common/country';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('admin/common/country');
    }

    public function index(Request $request)
    {    
        
        if (!Auth::user()->can('main-navigation-common-country')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_main_navigation_common_country.title'), 
        ];

        if (Auth::user()->can('main-navigation-common-country-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = Country::select('id','name','phone_code','country_code','region','regions_id');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

        $data = $data->paginate($perPage);

   

        return view('content.admin.common.country.index', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    
    public function edit($id){

        if (!Auth::user()->can('main-navigation-common-country-edit')) {
            abort(403);
        }

        $data = Country::with('regionData')->where('id', $id)->first();

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        
        $regions = RegionModel::select('id as value','name')->get();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        return view('content.admin.common.country.create', ['data' => $data,'activeSiteLanguages' => $activeSiteLanguages,'regions' =>$regions,'breadcrumbs' => $breadcrumbs,'menuUrl' => $this->menuUrl]);

    }

    public function create()
    {   
        if (!Auth::user()->can('main-navigation-common-country-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_main_navigation_common_country_add.title'), 
        ];

        $regions = RegionModel::select('id as value','name')->get();
        return view('content.admin.common.country.create',['breadcrumbs' => $breadcrumbs ,'regions' => $regions,'pageConfigs' => $pageConfigs,'menuUrl' =>$this->menuUrl]);
    }


    public function store(Request $request){

        if($request->id){
            if (!Auth::user()->can('main-navigation-common-country-edit')) {
                abort(403);
            }
             $country_model =   Country::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-common-country-add')) {
                abort(403);
            }
             $country_model =   new Country;
        }

        $request->validate(
                [
                    'name' => 'required|max:100|unique:regions,name,'.$request->id,
                    'phone_code' => 'nullable|max:10',
                    'country_code' => 'nullable|max:5',
                    'regions_id' => 'nullable|numeric',
                    'display' => 'required|in:Yes,No',
                ]  ,
                [   
                    'name.required'=> __('webCaption.validation_required.title', ['field'=> "Name" ] ),
                    'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
                    'name.max'=> __('webCaption.validation_max.title', ['field'=> "Name" ,"max" => "100"] ),
                    'phone_code.max'=> __('webCaption.validation_max.title', ['field'=> "Phone Code" ,"max" => "10"] ),
                    'country_code.max'=> __('webCaption.validation_max.title', ['field'=> "Country Code" ,"max" => "5"] ),
                    'regions_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Region"] ),
                    'display.required'=> __('webCaption.validation_required.title', ['field'=> "Display" ] ),
                    'display.in'=> __('webCaption.validation_in.title' ),
                ]                           
            );



            $country_model->name               =   $request->name;
            $country_model->phone_code          =   $request->phone_code;
            $country_model->country_code   =   $request->country_code;
            $country_model->regions_id   =   $request->regions_id;
            $country_model->display   =   $request->display;

            if($request->has('regions_id')){
               $region = RegionModel::where('id',$request->regions_id)->first()->value('name');
               $country_model->region          =  $region;
            }

            if($country_model->save()){
                
                $message = (isset($request->id)) ? $request->name." " .__('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title');  
                return redirect($this->baseUrl)->with(['success_message' => $message ]);
            }else{
                 return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
            }

    }



    public function destroy(Request $request){

        if (!Auth::user()->can('main-navigation-common-country-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }
        if(Country::where('id', $request->id)->firstorfail()->delete()){
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
