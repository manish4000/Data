<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\Dash\BankDetails;
use App\Models\Dash\CompanyBankDetails;
use App\Models\Masters\Country;
use App\Models\StateModel;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankDetailsController extends Controller
{   
    protected $basePath     =   '/';
    protected $baseUrl      =   '';
    protected $url;
    
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/dash/bank-details');
    }

    public function index(Request $request){

        $pageConfigs = [
            'moduleName' => __('webCaption.bank_details.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        // if (Auth::guard('dash')->user()->can('common_users_add')) {
        //     $breadcrumbs[0] = [
        //         'link' => $this->baseUrl.'/create',
        //         'name' => __('webCaption.add.title')
        //     ];
        // }else{
        //     $breadcrumbs[0] = [ ];
        // }

            $breadcrumbs[0] = [
                                'link' => $this->baseUrl.'/create',
                                'name' => __('webCaption.add.title')
                              ];

        $data = CompanyBankDetails::select('*');

        if( $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if( $request->has('search.status')) {
            $data->StatusFilter($request->input('search.status')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;
        $data = $data->paginate($perPage);

        return view('dash.content.bankDetails.index',['pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs,'data' =>$data]);
    }

    public function create(){

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
          ];
        $country = Country::get(['id as value' ,'name']);
        return view('dash.content.bankDetails.create',['country' => $country,'breadcrumbs' => $breadcrumbs]);
    }

    public function store(Request $request){
        $request->validate(
            [
            'bank_name' => 'required|string|max:255', 
            'dealer_name' => 'required|string|max:255', 
            'branch_name' => 'required|string|max:255', 
            'branch_code' => 'required|string|max:255', 
            'country_id' => 'required|string|max:255', 
            'account_name' => 'required|string|max:255', 
            'account_number' => 'required|string|max:255', 
            'account_address' => 'required|string|max:255', 
            'bank_address' => 'required|string|max:255', 
            'city_id' => 'required|numeric', 
            'state_id' => 'required|numeric', 
            'swift_code' => 'required|max:100', 
            'iban_no' => 'required|string|max:255', 
            'account_currency' => 'required|string|max:255', 
            'reason_for_remittance' => 'required|string|max:255', 
            'display_order' => 'required|integer' 
            ]
        );

        if($request->id){
           $bank_detail_model =   CompanyBankDetails::find($request->id);
        }else{
            $bank_detail_model =    new CompanyBankDetails;
        }

        $bank_detail_model->bank_name = $request->bank_name;
        $bank_detail_model->dealer_name = $request->dealer_name;
        $bank_detail_model->branch_name = $request->branch_name;
        $bank_detail_model->branch_code = $request->branch_code;
        $bank_detail_model->country_id = $request->country_id;
        $bank_detail_model->account_name = $request->account_name;
        $bank_detail_model->account_number = $request->account_number;
        $bank_detail_model->account_address = $request->account_address;
        $bank_detail_model->bank_address = $request->bank_address;
        $bank_detail_model->city_id = $request->city_id;
        $bank_detail_model->state_id = $request->state_id;
        $bank_detail_model->swift_code = $request->swift_code;
        $bank_detail_model->iban_no = $request->iban_no;
        $bank_detail_model->account_currency = $request->account_currency;
        $bank_detail_model->reason_for_remittance = $request->reason_for_remittance;
        $bank_detail_model->display_order = $request->display_order;
        $bank_detail_model->jumvea_account = (isset($request->jumvea_account)) ? "1" : "0" ;
        
        if($bank_detail_model->save()){
            $message = (isset($request->id)) ? $request->bank_name." ".__('webCaption.alert_updated_successfully.title') : $request->bank_name." ".__('webCaption.alert_added_successfully.title') ;
            return redirect($this->baseUrl)->with(['success_message' => $message ]);
        }else{
            return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
        }


    }

    public function edit($id){

        $data = CompanyBankDetails::find($id);
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
          ];

        $country = Country::get(['id as value' ,'name']);
        return view('dash.content.bankDetails.create',['country' => $country ,'data'=> $data,'breadcrumbs' => $breadcrumbs]);
    }

    public function destroy(Request $request){
        // if (!Auth::user()->can('main-navigation-masters-vehicle-type-delete')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_delete_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

        if(CompanyBankDetails::where('id', $request->id)->firstorfail()->delete()){
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

        // if (!Auth::user()->can('masters-vehicle-type-delete')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_delete_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

        if(CompanyBankDetails::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }


    public function stateList(Request $request){

        $state_list = StateModel::where('country_id',$request->id)->get();

        return response()->json( [ 'states' => $state_list]);

    }


    public function cityList(Request $request){

        $cities_list = CityModel::where('state_id',$request->id)->get();
        return response()->json( [ 'cities' => $cities_list]);
    }

    
    public function updateStatus(Request $request){
        
        // if (!Auth::user()->can('main-navigation-masters-vehicle-type-edit')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_update_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

        $data = CompanyBankDetails::FindOrFail($request->id);

        if(isset($data->status)){
            $status =  ($data->status == "1")? "0" : "1";
            $data->status = $status;
            $data->save();  
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_updated_successfully.title'); 
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 

        }


        return response()->json(['result' => $result]);
    }
}
