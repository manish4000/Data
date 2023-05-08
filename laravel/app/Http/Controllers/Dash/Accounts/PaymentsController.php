<?php

namespace App\Http\Controllers\Dash\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dash\Accounts\Payments;
use App\Models\Masters\Currency;
use App\Models\Masters\PaymentMode;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='accounts/payments';
    protected $status  =  [ 
        [ 'value' => 'Yes', 'name'=> 'Yes' ],
        [ 'value' => 'No', 'name'=> 'No' ]
    ];
 

    public function __construct(UrlGenerator $url)
    {   
        $this->url = $url;
        $this->baseUrl = $this->url->to('accounts/payments');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request){
        
        if (!Auth::guard('dash')->user()->can('accounts-payments')) {
            abort(403);
        }
        
        $pageConfigs = [
            'moduleName' => __('webCaption.accounts_payments.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::guard('dash')->user()->can('accounts-payments-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        } 
        
        $data = Payments::select('*');

        if( $request->has('search.keyword')) {
            $members->keywordFilter($request->input('search.keyword')); 
        }
        if( $request->has('search.status') && $request->input('search.status') != null ) {
            $members->StatusFilter($request->input('search.status')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $members->orderBy($request->order_by, $request->order);
        }
        
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        $data = $data->paginate($perPage);
        
        $status = json_decode(json_encode($this->status));

        return view('dash.content.accounts.payments.index',['status' => $status, 'perPage'=>$perPage, 'data'=>$data, 'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs]);
     }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(){

        if (!Auth::guard('dash')->user()->can('accounts-payments-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $payment_mode = PaymentMode::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('id as value','name')->orderBy('name')->get();

        return view('dash.content.accounts.payments.create',['breadcrumbs' => $breadcrumbs, 'payment_mode'=>$payment_mode,'currency'=>$currency]);
     }

     public function store(Request $request){  

        $old_payment_receipt_name = '';

        if($request->id){
            if (!Auth::guard('dash')->user()->can('accounts-payments-edit')) {
                abort(403);
            }

            $PaymentModel =    Payments::find($request->id);

            $old_payment_receipt_name = $PaymentModel->payment_receipt;
        }else{
            if (!Auth::guard('dash')->user()->can('accounts-payments-add')) {
                abort(403);
            }
            $PaymentModel = new Payments();
        }

        $request->validate(
        [
            'cash_in_date'    => 'required|date',
            'payment_ref_no'  => 'required|string|max:100',
            'currency'     => 'required|numeric',
            'amount'      => 'required|string|max:20',
            'ex_rate'    =>   'required|string|max:10',
            'client_id'      => 'nullable|string|max:5',
            'customer_name'      => 'nullable|string|max:100',
            'depositer_name'      => 'nullable|string|max:100',
            'memo'  =>  'nullable|string|max:250',
            'note_for_accounting' => 'nullable|string|max:250',
            'payment_mode'     => 'nullable|numeric',
            'refund_amount'     => 'nullable|numeric',
            'balance_amount'     => 'nullable|numeric',
            'refund_date'    => 'nullable|date',
            'payment_receipt'=> 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            
        ],
        [
            'cash_in_date.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.cash_in_date.title')] ),
            'cash_in_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.cash_in_date.title')] ),
            'payment_ref_no.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.payment_ref_no.title') ] ),
            'payment_ref_no.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.payment_ref_no.title') ] ),
            'payment_ref_no.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.payment_ref_no.title'), 'max'=>'100' ] ),
            'currency.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.currency.title')] ),
            'currency.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.currency.title')] ),
            'amount.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.amount.title')] ),
            'amount.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.amount.title')] ),
            'amount.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.amount.title') ,"max" => "20"] ),
            'ex_rate.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.ex_rate.title')] ),
            'ex_rate.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.ex_rate.title')] ),
            'ex_rate.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.ex_rate.title') ,"max" => "10"] ),
            'client_id.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.client_id.title')] ),
            'client_id.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.client_id.title') ,"max" => "5"] ),
            'customer_name.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.customer_name.title')] ),
            'customer_name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.customer_name.title') ,"max" => "100"] ),
            'depositer_name.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.depositer_name.title')] ),
            'depositer_name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.depositer_name.title') ,"max" => "100"] ),
            'memo.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.memo.title')] ),
            'memo.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.memo.title'), "max" => "250"] ),
            'note_for_accounting.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.note_for_accounting.title')] ),
            'note_for_accounting.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.note_for_accounting.title'), "max" => "250"] ),
            'payment_mode.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.payment_mode.title')] ),
            'refund_amount.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.refund_amount.title')] ),
            'balance_amount.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.balance_amount.title')] ),
            'refund_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.refund_date.title')] ),
            'payment_receipt.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.payment_receipt.title')] ),
            'payment_receipt.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.payment_receipt.title'),"fileTypes" => "jpg,png,jpeg"] ),
            'payment_receipt.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.payment_receipt.title'),"max" => "5000"] ),
    
        ]);

          $PaymentModel->cash_in_date = $request->cash_in_date;
          $PaymentModel->payment_status = $request->payment_status;
          $PaymentModel->payment_ref_no = $request->payment_ref_no;
          $PaymentModel->receiving_bank = $request->receiving_bank;
          $PaymentModel->amount = $request->amount;
          $PaymentModel->currency = $request->currency;
          $PaymentModel->ex_rate = $request->ex_rate;
          $PaymentModel->accounting_currency = $request->accounting_currency;
          $PaymentModel->balance_amount = $request->balance_amount;
          $PaymentModel->refund_amount = $request->refund_amount;
          $PaymentModel->refund_date = $request->refund_date;
          $PaymentModel->client_id = $request->client_id;
          $PaymentModel->customer_name = $request->customer_name;
          $PaymentModel->depositer_name = $request->depositer_name;
          $PaymentModel->payment_mode = $request->payment_mode;
          $PaymentModel->memo = $request->memo;
          $PaymentModel->note_for_accounting = $request->note_for_accounting;

          if($request->has('payment_receipt')){
                   
            $payment_receipt = time().'.'.$request->payment_receipt->extension();  
            $request->payment_receipt->move(public_path('dash/accounts/payment_receipt'), $payment_receipt);
            $ClientModel->payment_receipt = $payment_receipt;

            if(is_file(public_path('dash/accounts/payment_receipt').'/'.$old_payment_receipt_name)){
                unlink(public_path('dash/accounts/payment_receipt').'/'.$old_payment_receipt_name);
            }
        }

          if($PaymentModel->save()){
            $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('dashmembers.index')->with('success_message' ,$message );
        }else{
            return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title')]);
        }   

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {           
      
        if (!Auth::guard('dash')->user()->can('accounts-payments-edit')) {
            abort(403);
        }

        $data = Client::where('id', $id)->first();

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $payment_mode = PaymentMode::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('id as value','name')->orderBy('name')->get();

        return view('dash.content.accounts.payments.create',['data'=>$data, 'breadcrumbs' => $breadcrumbs, 'currency' => $currency, 'payment_mode'=>$payment_mode ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::guard('dash')->user()->can('accounts-payments-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Client::find($request->id);
        if(is_file(public_path('dash/accounts/payment_receipt').'/'.$data->payment_receipt )){
            unlink(public_path('dash/accounts/payment_receipt').'/'.$data->payment_receipt);
        }

        if(Client::where('id', $request->id)->delete()){
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

        if (!Auth::guard('dash')->user()->can('accounts-payments-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Client::whereIn('id', $request->delete_ids)->get();
        
        foreach($data as $item){
            if(is_file(public_path('dash/accounts/payment_receipt').'/'.$item->payment_receipt )){
                unlink(public_path('dash/accounts/payment_receipt').'/'.$item->payment_receipt);
            }
        }

        if(Client::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
            return response()->json(['result' => $result]);
       }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
       } 
    }

    public function updateStatus(Request $request){
        

       
        if (!Auth::guard('dash')->user()->can('accounts-payments-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = Client::FindOrFail($request->id);

        if(isset($__data->status)){
            $status =  ($__data->status == "Active") ? "Deactive" : "Active";

          
            if($__data->update(['status' => $status])  ){
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