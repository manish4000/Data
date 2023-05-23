<?php
namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Dash\CompanySalesTeam;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Dash\Inquiry;
use App\Models\Masters\Vehicles\Transmission;
use App\Models\Masters\Vehicles\Fuel;  
use App\Models\Masters\Currency;
use App\Models\Masters\Country;
use App\Models\Ports;
use App\Models\Dash\Masters\Rating;
use App\Models\Dash\Masters\Terms;
use App\Models\Masters\Company\Messenger;
use PhpParser\Node\Expr\Cast\Object_;

class InquiryController extends Controller
{   
    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='inquiries';


    public function __construct(UrlGenerator $url)
    {   
        $this->url = $url;
        $this->baseUrl = $this->url->to('inquiries');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request){
        
        if (!Auth::guard('dash')->user()->can('crm-inquiries')) {
            abort(403);
        }
        
        $pageConfigs = [
            'moduleName' => __('webCaption.inquiries.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::guard('dash')->user()->can('crm-inquiries-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [];
        } 
        
        $inquiry = Inquiry::select('*');

        if( $request->has('search.keyword')) {
            $inquiry->keywordFilter($request->input('search.keyword')); 
        }
    
        if($request->has('order_by') &&  $request->has('order') ){
            $inquiry->orderBy($request->order_by, $request->order);
        }
        
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        $inquiry = $inquiry->paginate($perPage);
        
        //$status = json_decode(json_encode($this->status));

        return view('dash.content.inquiry.index',['inquiries'=>$inquiry, 'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs, 'perPage'=>$perPage]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (!Auth::guard('dash')->user()->can('crm-inquiries-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        
        $transmission = Transmission::select('id as value','name')->orderBy('name')->get();
        $fuel = Fuel::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('name as value', 'name')->orderBy('name')->get();
        $country = Country::select('id as value','name')->orderBy('name')->get();
        $ports = Ports::select('id as value','name')->orderBy('name')->get();
        $terms = Terms::select('id as value','name')->orderBy('name')->get();
        $rating = Rating::select('id as value','name')->orderBy('name')->get();
        $country_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();
        $sales_person = CompanySalesTeam::select('id as value','name')->where('deleted_at', null)->orderBy('name')->get();

        $year = array();
        for($y=1950; $y<=Date('Y')+1; $y++){
            $year[] = (Object) array('value'=> $y, 'name' => $y);
        }

        $purchaseCap = array();
        for($pc=1; $pc<=100; $pc++){
            $purchaseCap[] = (Object) array('value'=> $pc, 'name' => $pc);
        }
      
        return view('dash.content.inquiry.create',['breadcrumbs' => $breadcrumbs, 'transmission' => $transmission, 'fuel'=>$fuel, 'currency'=>$currency, 'country'=>$country, 'ports'=>$ports, 'terms'=>$terms, 'country_code'=>$country_code, 'rating'=>$rating, 'sales_person' => $sales_person, 'year' => $year, 'purchase_cap' => $purchaseCap]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  
       //dd($request->all());
       if($request->id){
            if (!Auth::guard('dash')->user()->can('crm-inquiries-edit')) {
                abort(403);
            }
            $inquiryModel =    Inquiry::find($request->id);
        }else{
            if (!Auth::guard('dash')->user()->can('crm-inquiries-add')) {
                abort(403);
            }
            $inquiryModel = new Inquiry();
        }

        $request->validate([
            'name'               => 'required',
            'email'              => 'required|email|unique:inquiry,email,'.$request->id,
            'make'               => 'required|nullable',
            'model'              => 'required|nullable',
            'phone'              => 'required|nullable',
            'country'            => 'required|numeric|nullable',
            'country_code'       => 'required_with:phone',
        ],[
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
            'email.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title')] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> __('webCaption.email.title') ] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'make.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.make.title') ] ),
            'model.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.model.title') ] ),
            'phone.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.phone.title') ] ),
            'country.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country.title') ] ),
            'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),
        ]);

        $inquiryArr = array();

        $inquiryArr['company_id'] =  NULL;
        $inquiryArr['stock_number'] =  $request->stock_number;
        $inquiryArr['type'] = $request->type; 
        $inquiryArr['subtype'] = $request->subtype;
        $inquiryArr['make'] = $request->make;
        $inquiryArr['model'] = $request->model;
        $inquiryArr['model_code'] = $request->model_code;
        $inquiryArr['chassis_no'] = $request->chassis_no;
        $inquiryArr['year_from'] = $request->year_from;
        $inquiryArr['year_to'] = $request->year_to;
        $inquiryArr['mileage'] = $request->mileage;
        $inquiryArr['budget'] = $request->budget;
        $inquiryArr['customer_message'] = $request->customer_message;
        $inquiryArr['name'] = $request->name;
        $inquiryArr['email'] = $request->email;
        $inquiryArr['purchase_capacity'] = $request->purchase_capacity;
        $inquiryArr['customer_type'] = $request->customer_type;
        $inquiryArr['phone'] = $request->country_code."_".$request->phone;
        $inquiryArr['next_contact_date'] = $request->next_contact_date;        
        $inquiryArr['admin_memo'] = $request->admin_memo;
        $inquiryArr['currency'] = $request->currency;
        $inquiryArr['inquiry_date'] = $request->inquiry_date;
        $inquiryArr['dealer_comment'] = $request->dealer_comment;
        
        //Fuel
        $inquiryArr['fuel_id'] = $request->fuel;
        if(isset($request->fuel) && !empty($request->fuel)){
            $fuel_name  = Fuel::select('name')->where('id', $request->fuel)->get()->value('name');
            $inquiryArr['fuel'] = $fuel_name; 
        }else $inquiryArr['fuel'] = NULL;
        
        //Transmission
        $inquiryArr['transmission_id'] = $request->transmission;
        if(isset($request->transmission) && !empty($request->transmission)){
            $transmission_name = Transmission::select('name')->where('id', $request->transmission)->get()->value('name');
            $inquiryArr['transmission'] = $transmission_name;
        }else $inquiryArr['transmission'] = NULL;

        //Terms
        $inquiryArr['terms_id'] = $request->terms;
        if(isset($request->terms) && !empty($request->terms)){
            $terms_name = Terms::select('name')->where('id', $request->terms)->get()->value('name');
            $inquiryArr['terms'] = $terms_name;
        }else $inquiryArr['terms'] = NULL;
        
        //Country
        $inquiryArr['country_id'] = $request->country;
        if(isset($request->country) && !empty($request->country)){
            $country_name = Country::select('name')->where('id', $request->country)->get()->value('name');
            $inquiryArr['country'] = $country_name;
        }else $inquiryArr['country'] = NULL;
        
        //Port
        $inquiryArr['port_id'] = $request->port;
        if(isset($request->port) && !empty($request->port)){
            $ports_name = Ports::select('name')->where('id', $request->port)->get()->value('name');
            $inquiryArr['port'] = $ports_name;
        }else $inquiryArr['port'] = NULL;

        //Rating
        $inquiryArr['rating_id'] = $request->rating;
        if(isset($request->rating) && !empty($request->rating)){
            $rating_name = Rating::select('name')->where('id', $request->rating)->get()->value('name');
            $inquiryArr['rating'] = $rating_name;
        }else $inquiryArr['rating'] = NULL;

        //Source
        $inquiryArr['source_id'] = $request->source;
        if(isset($request->source) && !empty($request->source)){
            $inquiryArr['source'] = NULL;
        }

        //Stage
        $inquiryArr['stage_id'] =  $request->stage;
        if(isset($request->stage) && !empty($request->stage)){
            $inquiryArr['stage'] =  NULL;
        }

        //Sales Person
        if(isset($request->sales_person) && !empty($request->sales_person)){
            $inquiryArr['sales_person_id'] = $request->sales_person;
            $sales_person_name = CompanySalesTeam::select('name')->where('id', $request->sales_person)->get()->value('name');
            $inquiryArr['sales_person'] = $sales_person_name;
        }else{
            $inquiryArr['sales_person_id'] = NULL;
            $inquiryArr['sales_person'] = NULL;
        }
        
        //Messenger
        if($request->has('messenger')) {
            $messenger = [];
            foreach($request->messenger as $key=>$value){
                $messenger_name = Messenger::where('name','!=',null)->where('id',$value)->get()->value('name');
                
                $messenger[$key]['id'] = $value;
                $messenger[$key]['value']= $messenger_name;
             }    
            $inquiryArr['messenger'] = json_encode($messenger);    
        }
        else{
            $inquiryArr['messenger'] = NULL; 
        }
      

        if(isset($request->id) && !empty($request->id)){
            $inquiryArr['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();

            $inquiryModel->update($inquiryArr);
            $message = $request->name." ". __('webCaption.alert_updated_successfully.title');
        } 
        else{
            
            $inquiryArr['created_at'] =  \Carbon\Carbon::now()->toDateTimeString();
            $inquiryArr['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();

            //echo "<pre>"; print_r($inquiryArr); echo "</pre>"; exit;
            $inquiryModel->insert($inquiryArr);

            $message =  $request->name." ". __('webCaption.alert_added_successfully.title');
        }

        return redirect()->route('dashinquiries.index')->with('success_message', $message);
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
        if (!Auth::guard('dash')->user()->can('crm-inquiries-edit')) {
            abort(403);
        }

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $inquiry = Inquiry::find($id);

        $transmission = Transmission::select('id as value','name')->orderBy('name')->get();
        $fuel = Fuel::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('name as value', 'name')->orderBy('name')->get();
        $country = Country::select('id as value','name')->orderBy('name')->get();
        $ports = Ports::select('id as value','name')->orderBy('name')->get();
        $terms = Terms::select('id as value','name')->orderBy('name')->get();
        $rating = Rating::select('id as value','name')->orderBy('name')->get();
        $country_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();
        $sales_person = CompanySalesTeam::select('id as value','name')->where('deleted_at', null)->orderBy('name')->get();

        $year = array();
        for($y=1950; $y<=Date('Y')+1; $y++){
            $year[] = (Object) array('value'=> $y, 'name' => $y);
        }

        $purchaseCap = array();
        for($pc=1; $pc<=100; $pc++){
            $purchaseCap[] = (Object) array('value'=> $pc, 'name' => $pc);
        }
      
        return view('dash.content.inquiry.create',['breadcrumbs' => $breadcrumbs, 'data' => $inquiry, 'transmission' => $transmission, 'fuel'=>$fuel, 'currency'=>$currency, 'country'=>$country, 'ports'=>$ports, 'terms'=>$terms, 'country_code'=>$country_code, 'rating'=>$rating, 'sales_person' => $sales_person, 'year' => $year, 'purchase_cap' => $purchaseCap]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::guard('dash')->user()->can('crm-inquiries-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        //$data = Inquiry::find($request->id);

        if(Inquiry::where('id', $request->id)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
            return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple(Request $request)
    {
        if (!Auth::guard('dash')->user()->can('crm-inquiries-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(Inquiry::whereIn('id', $request->delete_ids)->delete()){
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
