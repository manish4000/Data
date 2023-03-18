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
        $this->baseUrl =  $this->url->to('bank-details');
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
        if( isset($request->account_number)) {
            $data->AccountNumberFilter($request->account_number); 
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
            'country_id' => 'required|numeric', 
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
            ],
            [
                'bank_name.required' => __('webCaption.validation_required.title', ['field'=> "Bank Name" ] ),
                'bank_name.string' => __('webCaption.validation_string.title', ['field'=> "Bank Name" ] ),
                'bank_name.max' => __('webCaption.validation_max.title', ['field'=> "Bank Name" ,'max' =>"255" ] ),

                'dealer_name.required' => __('webCaption.validation_required.title', ['field'=> "Dealer Name" ] ),
                'dealer_name.string' => __('webCaption.validation_string.title', ['field'=> "Dealer Name" ] ),
                'dealer_name.max' => __('webCaption.validation_max.title', ['field'=> "Dealer Name" ,'max' =>"255" ] ),

                'branch_name.required' => __('webCaption.validation_required.title', ['field'=> "Branch Name" ] ),
                'branch_name.string' => __('webCaption.validation_string.title', ['field'=> "Branch Name" ] ),
                'branch_name.max' => __('webCaption.validation_max.title', ['field'=> "Branch Name" ,'max' =>"255" ] ),

                'branch_code.required' => __('webCaption.validation_required.title', ['field'=> "Branch Code" ] ),
                'branch_code.string' => __('webCaption.validation_string.title', ['field'=> "Branch Code" ] ),
                'branch_code.max' => __('webCaption.validation_max.title', ['field'=> "Branch Code" ,'max' => '255' ] ),

                'country_id.required' => __('webCaption.validation_required.title', ['field'=> "Country" ] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Country" ] ),
           

                'account_name.required' => __('webCaption.validation_required.title', ['field'=> "Account Name" ] ),
                'account_name.string' => __('webCaption.validation_string.title', ['field'=> "Account Name" ] ),
                'account_name.max' => __('webCaption.validation_max.title', ['field'=> "Account Name" ,"max" => "255" ] ),

                'account_number.required' => __('webCaption.validation_required.title', ['field'=> "Account Number" ] ),
                'account_number.string' => __('webCaption.validation_string.title', ['field'=> "Account Number" ] ),
                'account_number.max' => __('webCaption.validation_max.title', ['field'=> "Account Number" ,"max" => "255" ] ),

                'account_address.required' => __('webCaption.validation_required.title', ['field'=> "Account Address" ] ),
                'account_address.string' => __('webCaption.validation_string.title', ['field'=> "Account Address" ] ),
                'account_address.max' => __('webCaption.validation_max.title', ['field'=> "Account Address" ,"max" => "255" ] ),

                'bank_address.required' => __('webCaption.validation_required.title', ['field'=> "Bank Address" ] ),
                'bank_address.string' => __('webCaption.validation_string.title', ['field'=> "Bank Address" ] ),
                'bank_address.max' => __('webCaption.validation_max.title', ['field'=> "Bank Address"  ,"max" => "255"] ),

                'city_id.required' => __('webCaption.validation_required.title', ['field'=> "City" ] ),
                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "City" ] ),

                'state_id.required' => __('webCaption.validation_required.title', ['field'=> "State" ] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "State" ] ),

                'swift_code.required' => __('webCaption.validation_required.title', ['field'=> "Swift Code" ] ),
                'swift_code.max' => __('webCaption.validation_max.title', ['field'=> "Swift Code" ,"max" => "100" ] ),

                'iban_no.required' => __('webCaption.validation_required.title', ['field'=> "Iban Number" ] ),
                'iban_no.string' => __('webCaption.validation_string.title', ['field'=> "Iban Number" ] ),
                'iban_no.max' => __('webCaption.validation_max.title', ['field'=> "Iban Number" ,"max" =>"255" ] ),

                'account_currency.required' => __('webCaption.validation_required.title', ['field'=> "Account Currency" ] ),
                'account_currency.string' => __('webCaption.validation_string.title', ['field'=> "Account Currency" ] ),

                'reason_for_remittance.required' => __('webCaption.validation_required.title', ['field'=> "Reason For Remittance" ] ),
                'reason_for_remittance.string' => __('webCaption.validation_string.title', ['field'=> "Reason For Remittance" ] ),

                'display_order.required' => __('webCaption.validation_required.title', ['field'=> "Display Order" ] ),
                'display_order.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Display Order" ] ),
                
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
