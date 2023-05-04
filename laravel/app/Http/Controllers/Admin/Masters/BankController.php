<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Company\Bank;
use App\Models\Masters\Country;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/company/bank';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/company/bank');
    }

    public function index(Request $request){    
        if (!Auth::user()->can('masters-company-bank')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_company_bank.title'), 
        ];

        if (Auth::user()->can('masters-company-bank-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = Bank::withCount('children');

        if($request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
            $data->displayStatusFilter($request->input('search.displayStatus')); 
        }

        if($request->has('search.country_id') && $request->input('search.country_id') != '') {
            $data->countryFilter($request->input('search.country_id')); 
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
        $country = Country::select('id as value', 'name')->orderBy('name')->get();
        return view('content.admin.masters.company.bank.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage, 'country' => $country]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() {

        if (!Auth::user()->can('masters-company-bank-add')) {
            abort(403);
        }

        $parent_data = Bank::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        $country = Country::select('id as value', 'name')->orderBy('name')->get();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        return view('content.admin.masters.company.bank.create-form',['menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs ,'parent_data' => $parent_data, 'country' => $country]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

         $old_logo_name = '';
        if($request->id){
            if (!Auth::user()->can('masters-company-bank-edit')) {
                abort(403);
            }
            $bank_model =   Bank::find($request->id);

            $old_logo_name =   $bank_model->logo;
        }else{
            if (!Auth::user()->can('masters-company-bank-add')) {
                abort(403);
            }
            $bank_model =   new Bank;
        }

        $validator = Validator::make($request->all(),
          [
            'display' => 'required',
            'name' => 'required|unique:banks,name,'.$request->id.',id,deleted_at,NULL',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
            'country_id' => 'nullable|numeric',
          ]  ,
          [
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
            'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
            'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),

            'logo.required_without'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.logo.title') ] ),
            /* 'logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.logo.title') ] ), */
            'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.logo.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.logo.title') ,"max" => "5000"] ),
            'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),
          ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

            $bank_model->name   =   $request->name;    
            if(isset($request->country_id) && !empty($request->country_id)){
                $bank_model->country_id    =   $request->country_id;

                $country = Country::select('name')->where('id', $request->country_id)->get()->value('name');
                $bank_model->country    =   $country;
            }else{
                $bank_model->country_id  = NULL;
                $bank_model->country  = NULL;
            }

            if($request->has('logo')){
                $logo = time().rand('111', '999').'.'.$request->logo->extension();
                $request->logo->move(public_path('master/company/bank/'), $logo);
                $bank_model->logo   =   $logo;

                if(is_file(public_path('master/company/bank/').$old_logo_name)){
                    unlink(public_path('master/company/bank/').$old_logo_name);
                }
            }

                $bank_model->parent_id  =   isset($request->parent_id)? $request->parent_id : 0 ;
                $bank_model->display    =   $request->display;
                // $bank_model->title_languages    =   $request->title_languages;

                if($bank_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('masters.company.bank.index')->with('success_message' ,$message );
                }else{
                    return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
                }
                
            }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){   

        if (!Auth::user()->can('masters-company-bank-edit')){
            abort(403);
        }
        $data = Bank::select('id', 'name','title_languages', 'parent_id', 'display','logo','country_id')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        //send id as value because dynamic select work with  id as value  name as name  
        $parent_data = Bank::select('id as value', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', '0')->get();
        $country = Country::select('id as value', 'name')->orderBy('name')->get();


        return view('content.admin.masters.company.bank.create-form',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'parent_data' => $parent_data ,'menuUrl' =>$this->menuUrl, 'country' => $country]);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {

        if (!Auth::user()->can('masters-company-bank-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Bank::find($request->id);
        
        if(is_file(public_path('master/company/bank/').$data->logo )){
            unlink(public_path('master/company/bank/').$data->logo);
        }

        if(Bank::where('id', $request->id)->firstorfail()->delete()){
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

        if (!Auth::user()->can('masters-company-bank-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Bank::whereIn('id', $request->delete_ids)->get();
        
        foreach($data as $item){
            if(is_file(public_path('master/company/bank/').$item->logo)){
                unlink(public_path('master/company/bank/').$item->logo);
            }
        }

        if(Bank::whereIn('id', $request->delete_ids)->delete()){
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

        
        if (!Auth::user()->can('masters-company-bank-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = Bank::FindOrFail($request->id);

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
