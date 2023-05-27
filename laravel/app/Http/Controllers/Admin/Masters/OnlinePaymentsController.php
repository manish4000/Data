<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Company\OnlinePayments;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class OnlinePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/company/online-payments';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/company/online-payments');
    }

    public function index(Request $request)
    {    
        if (!Auth::user()->can('masters-company-online-payments')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_company_online_payments.title'), 
        ];

        if (Auth::user()->can('masters-company-online-payments-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }

        $data = OnlinePayments::select('*');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
            $data->displayStatusFilter($request->input('search.displayStatus')); 
        }   

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        return view('content.admin.masters.company.online_payments.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() {

        if (!Auth::user()->can('masters-company-online-payments-add')) {
            abort(403);
        }
       
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        return view('content.admin.masters.company.online_payments.create-form',['menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs]);
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
            if (!Auth::user()->can('masters-company-online-payments-edit')) {
                abort(403);
            }
            $online_payments_model =   OnlinePayments::find($request->id);

            $old_logo_name = $online_payments_model->logo; 
        }else{
            if (!Auth::user()->can('masters-company-online-payments-add')) {
                abort(403);
            }
            $online_payments_model =   new OnlinePayments;
        }

        $validator = Validator::make($request->all(),
          [
          
            'name' => 'required|unique:dash.online_payments,name,'.$request->id.',id,deleted_at,NULL',
            'logo'=> 'required_without:id|image|mimes:jpeg,png,jpg,gif|max:5000',
            'commission' => 'nullable|numeric',
          ]  ,
          [
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
            'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
            'logo.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.logo.title') ] ),
            'logo.required_without'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.logo.title') ] ),
            'logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.logo.title') ] ),
            'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.logo.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.logo.title') ,"max" => "5000"] ),
            'commission.numeric'=> __('webCaption.validation_numeric.title', ['field'=> __('webCaption.commission.title') ] ),
          ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

                $online_payments_model->name       =   $request->name;
                $online_payments_model->commission     =   $request->commission;
                $online_payments_model->description    =   $request->description;

                if($request->has('logo')){
                   
                    $logo = time().'.'.$request->logo->extension();  
                    $request->logo->move(public_path('online_payments'), $logo);
                    $online_payments_model->logo = $logo;

                    if(is_file(public_path('online_payments').'/'.$old_logo_name )){
                        unlink(public_path('online_payments').'/'.$old_logo_name);
                    }
                }

                if($online_payments_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('masters.company.online-payments.index')->with('success_message' ,$message );
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
        if (!Auth::user()->can('masters-company-online-payments-edit')) {
            abort(403);
        }
        $data = OnlinePayments::select('id', 'name', 'commission', 'description', 'logo')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        return view('content.admin.masters.company.online_payments.create-form',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'menuUrl' =>$this->menuUrl]);
   
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

        if (!Auth::user()->can('masters-company-online-payments-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = OnlinePayments::find($request->id);
        
        if(is_file(public_path('online_payments').'/'.$data->logo)){
            unlink(public_path('online_payments').'/'.$data->logo);
        }

        if(OnlinePayments::where('id', $request->id)->firstorfail()->delete()){
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

        if (!Auth::user()->can('masters-company-online-payments-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = OnlinePayments::whereIn('id', $request->delete_ids)->get();
        
        foreach($data as $item){
            if(is_file(public_path('online_payments').'/'.$item->logo )){
                unlink(public_path('online_payments').'/'.$item->logo);
            }
        }

        if(OnlinePayments::whereIn('id', $request->delete_ids)->delete()){
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

        
        if (!Auth::user()->can('masters-company-online-payments-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = OnlinePayments::FindOrFail($request->id);

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
