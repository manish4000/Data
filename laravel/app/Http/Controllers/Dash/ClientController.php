<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dash\Client;
use App\Models\Dash\CompanySalesTeam;
use App\Models\Masters\Country;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\Religion;
use App\Models\Ports;
use App\Models\Masters\Nationality;
use App\Models\Masters\SocialMedia;
use App\Models\Dash\Masters\Rating;
use App\Models\Dash\Masters\Terms;
use App\Models\Masters\Currency;
use App\Models\Masters\Company\Messenger;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='members';

    public function __construct(UrlGenerator $url)
    {   
        $this->url = $url;
        $this->baseUrl = $this->url->to('members');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request){
        
        if (!Auth::guard('dash')->user()->can('members')) {
            abort(403);
        }
        
        $pageConfigs = [
            'moduleName' => __('webCaption.members.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::guard('dash')->user()->can('members-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        } 
        
        $members = Client::select('*');

        if( $request->has('search.keyword')) {
            $members->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $members->orderBy($request->order_by, $request->order);
        }
        
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        $members = $members->paginate($perPage);

        return view('dash.content.members.index',['members'=>$members, 'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs, 'perPage'=>$perPage]);
     }

     public  function checkUidExist(Request $request){

        if(Client::select("*")->where("customer_uid",$request->uid)->exists()){

            $result['status']     = true;
            $result['message']    = 'Value Exist'; 
            return response()->json(['result' => $result]);
        }else{
            $result['status']     = false;
            $result['message']    = 'Value not Exist'; 
            return response()->json(['result' => $result]);
        }
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(){

        if (!Auth::guard('dash')->user()->can('members-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $country_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();
        $country = Country::select('id as value','name')->orderBy('name')->get();
        $port = Ports::select('id as value','name')->orderBy('name')->get();
        $religion = Religion::select('id as value','name')->orderBy('name')->get();
        $social_media = SocialMedia::select('id as value','name')->orderBy('name')->get();
        $sales_person = CompanySalesTeam::select('id as value' , 'name')->orderBy('name')->get();
        $rating = Rating::select('id as value','name')->orderBy('name')->get();
        // $stage = Stage::select('id as value','name')->orderBy('name')->get();
        $terms = Terms::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('id as value','name')->orderBy('name')->get();

        $countingArr = array();
        for($c=1; $c<=100; $c++){
            $countingArr[] = (Object) array('value'=> $c, 'name' => $c);
        }

        return view('dash.content.members.create',['breadcrumbs' => $breadcrumbs, 'country'=>$country, 'port'=>$port, 'religion'=>$religion, 'country_code'=>$country_code, 'social_media'=>$social_media, 'rating'=>$rating, 'terms'=>$terms , 'currency'=>$currency, 'countingArr'=>$countingArr, 'sales_person'=>$sales_person]);
     }

     public function store(Request $request){  

        $old_visiting_card_img_name = '';
        $old_user_image_name = '';
        $old_company_logo_name = '';

      
        if($request->id){
            if (!Auth::guard('dash')->user()->can('members-edit')) {
                abort(403);
            }

            $ClientModel =    Client::find($request->id);

            $old_visiting_card_img_name = $ClientModel->visiting_card_img;
            $old_user_image_name = $ClientModel->user_image;
            $old_company_logo_name = $ClientModel->company_logo;

        }else{
            if (!Auth::guard('dash')->user()->can('members-add')) {
                abort(403);
            }
            $ClientModel = new Client();
        }

        $request->validate(
        [
            'company_name'  => 'required|max:100|unique:clients,company_name,'.$request->id.',id,deleted_at,NULL', 
            'title'        => 'required|string',
            'name'          => 'required|max:100',
            'customer_uid'  => 'nullable|max:6',
            'password'      => 'nullable|min:8',
            'email_1'       => 'required|max:45|unique:clients,email_1,'.$request->id. ',id,deleted_at,NULL',
            'email_2'       => 'nullable|max:45|unique:clients,email_2,'.$request->id. ',id,deleted_at,NULL',
            'mobile_1'      => 'required|string|max:20',
            'mobile_2'      => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:250',
            'city'          => 'nullable|numeric',
            'state'         => 'nullable|numeric',
            'country'       => 'required|numeric',
            'port'          => 'nullable|numeric',
            'zip_code'      => 'nullable|string|max:15',
            'birth_date'    => 'nullable|date',
            'anniversary_date'   => 'nullable|date',
            'next_follow_up_date'   => 'nullable|date',
            //'country_code' => 'required_with:mobile_1',

            'sales_person'  => 'nullable|numeric',
            'rating'       => 'nullable|numeric',
            'stage'        => 'nullable|numeric',
            'term'         => 'nullable|numeric',
            'religion'      => 'nullable|numeric',
            'nationality'   => 'nullable|numeric',
            'storage_days'  => 'nullable|numeric',
            'bid_limitations'  => 'nullable|numeric',
            'intial_payment_due_days'  => 'nullable|numeric',
            'uss_images'  => 'nullable|numeric',

            'opening_balance_date' => 'nullable|date',
            'currency'     => 'nullable|numeric',

            'admin_memo'  =>  'nullable|string|max:250',

            'visiting_card_img'=> 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            'user_image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            'company_logo' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',

            'registration_date'  => 'nullable|date',
            'registered_ip'  => 'nullable|string|max:50',
        ],
        [
            'title.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.title.title') ] ),
            'title.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.title.title') ] ),
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
            'name.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),
            'customer_uid.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.customer_uid.title') ] ),
            'customer_uid.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.customer_uid.title'),"max" => "6"] ),
            'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
            'mobile_1.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.mobile_1.title')] ),
            'mobile_1.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.mobile_1.title')] ),
            'mobile_1.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.mobile_1.title') ,"max" => "20"] ),
            'mobile_2.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.mobile_2.title')] ),
            'mobile_2.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.mobile_2.title') ,"max" => "20"] ),
            //'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),

            'admin_memo.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.admin_memo.title'), "max" => "250"] ),
            'registered_ip.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.registered_ip.title'), "max" => "50"] ),

            'currency.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.currency.title')] ),
            'city.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.city.title')] ),
            'state.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.state.title') ] ),
            'country.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country.title') ] ),
            'country.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),
            'port.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.port.title') ] ),
            'address.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.address.title'), "max" => "250" ] ),
            'address.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.address.title') ] ),
            'zip_code.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.zip_code.title')] ),
            'zip_code.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.zip_code.title') ,"max" => "15"] ),

            'religion.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.religion.title')] ),
            'nationality.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.nationality.title')] ),
            'sales_person.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.sales_person.title')] ),
            'rating.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.rating.title')] ),
            'stage.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.stage.title')] ),
            'term.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.term.title')] ),
            'storage_days.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.storage_days.title')] ),
            'bid_limitations.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.bid_limitations.title')] ),
            'intial_payment_due_days.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.intial_payment_due_days.title')] ),
            'uss_images.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.uss_images.title')] ),

            'birth_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.birth_date.title')] ),
            'anniversary_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.anniversary_date.title')] ),
            'next_follow_up_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.next_follow_up_date.title')] ),
            'opening_balance_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.opening_balance_date.title')] ),
            'registration_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.registration_date.title')] ),

            'email_1.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.email_1.title') ] ),
            'email_1.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email_1.title') ,"max" => "45"] ),
            'email_1.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email_1') ] ),
            'email_2.nullable'=> __('webCaption.validation_nullable.title', ['field'=> __('webCaption.email_2.title') ] ),
            'email_2.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email_2.title') ,"max" => "45"] ),
            'email_2.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email_2') ] ),

            'visiting_card_img.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.visiting_card_img.title')] ),
            'visiting_card_img.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.visiting_card_img.title'),"fileTypes" => "jpg,png,jpeg"] ),
            'visiting_card_img.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.visiting_card_img.title'),"max" => "5000"] ),

            'user_image.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.user_image.title')] ),
            'user_image.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.user_image.title'),"fileTypes" => "jpg,png,jpeg"] ),
            'user_image.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.user_image.title'),"max" => "5000"] ),

            'company_logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.company_logo.title')] ),
            'company_logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.company_logo.title'),"fileTypes" => "jpg,png,jpeg"] ),
            'company_logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.company_logo.title'),"max" => "5000"] ),
        ]);

        if(!isset($request->id)){
            $request->validate([
                'password' => 'required|min:8',
                'customer_uid'  => 'required|max:6',   
            ],[
                'password.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.password.title') ] ),
                'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),

                'customer_uid.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.customer_uid.title') ] ),
                'customer_uid.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.customer_uid.title') ,'max' => "6"] ),
            ]);
        }


        if($request->password != null){
            $ClientModel->password = $request->password ;
        }

          $company_id = Auth::guard('dash')->user()->id;
          $ClientModel->company_id = $company_id;
          
          $ClientModel->title = $request->title;
          $ClientModel->name = $request->name;
          $ClientModel->company_name = $request->company_name;
          if($request->customer_uid != null){
            $ClientModel->customer_uid = $request->customer_uid;
          }
          
          $ClientModel->email_1 = $request->email_1;
          $ClientModel->email_2 = $request->email_2;
          $ClientModel->mobile_1 = $request->country_code_1.'_'.$request->mobile_1;
         
          if($request->has('messenger_1')) {
             
                $messengerArr_1 = [];
                foreach($request->messenger_1 as $key=> $value){
                    $messenger_name_1 = Messenger::where('name','!=',null)->where('id',$value)->get()->value('name');
                    
                    $messengerArr_1[$key]['id'] = $value;
                    $messengerArr_1[$key]['value']= $messenger_name_1;
                 }    
            $ClientModel->messenger_1 = json_encode($messengerArr_1);     
        }else{
            $ClientModel->messenger_1 = null;
        }
          
          $ClientModel->mobile_2 = $request->country_code_2.'_'.$request->mobile_2;

          if($request->has('messenger_2')) {
                $messengerArr_2 = [];
                foreach($request->messenger_2 as $key=>$value){
                $messenger_name_2 = Messenger::where('name','!=',null)->where('id',$value)->get()->value('name');;
                $messengerArr_2[$key]['id'] = $value;
                $messengerArr_2[$key]['value']= $messenger_name_2;         
            }    
            $ClientModel->messenger_2 = json_encode($messengerArr_2);
        }else{
        $ClientModel->messenger_2 = null;
        }
          
          $ClientModel->dealer_type = $request->dealer_type;
          $ClientModel->member_login = $request->member_login;
          $ClientModel->broker = isset($request->broker)?"Yes":"No";
          $ClientModel->address = $request->address;

          $ClientModel->city_id = $request->city;
          $city = CityModel::select('name')->where('id',$request->city)->get()->value('name');
          $ClientModel->city   =  $city;  
          
          $ClientModel->state_id = $request->state;
          $state = StateModel::select('name')->where('id',$request->state)->get()->value('name');
          $ClientModel->state   =  $state; 

          $ClientModel->country_id = $request->country;
          $country = Country::select('name')->where('id',$request->country)->get()->value('name');
          $ClientModel->country   =  $country;

          $ClientModel->port_id = $request->port;
          $port = Ports::select('name')->where('id',$request->port)->get()->value('name');
          $ClientModel->port   =  $port;

          $ClientModel->zip_code = $request->zip_code;

          $ClientModel->religion_id = $request->religion;
          $religion = Religion::select('name')->where('id',$request->religion)->get()->value('name');
          $ClientModel->religion   =  $religion;

          $ClientModel->nationality_id = $request->nationality;
          $nationality = Country::select('name')->where('id',$request->nationality)->get()->value('name');
          $ClientModel->nationality   =  $nationality;

          $ClientModel->birth_date = $request->birth_date;
          $ClientModel->anniversary_date = $request->anniversary_date;
          
          if($request->has('social_media')){
            if(is_array($request->social_media) && count($request->social_media)>0){
            $socialArr = array();
                    foreach($request->social_media as $key=>$value){
                    $social_name  = SocialMedia::select('name')->where('id', $value)->get()->value('name'); 
                        $socialArr[$key]['id'] = $value;
                        $socialArr[$key]['name'] = $social_name;
                        $socialArr[$key]['value'] = $request->social_value[$key];       
                }
                $ClientModel->social_media = json_encode($socialArr);
            }
        }
        
          $ClientModel->sales_person_id = $request->sales_person;
          $sales_person = CompanySalesTeam::select('name')->where('id',$request->sales_person)->get()->value('name');
          $ClientModel->sales_person   =  $sales_person;

          $ClientModel->rating_id = $request->rating;
          $rating = Rating::select('name')->where('id',$request->rating)->get()->value('name');
          $ClientModel->rating   =  $rating;

          $ClientModel->stage_id = $request->stage;
          //$stage = Stage::select('name')->where('id',$request->stage)->get()->value('name');
          //$ClientModel->stage   =  $stage;

          $ClientModel->terms_id = $request->terms;
          $terms = Terms::select('name')->where('id',$request->terms)->get()->value('name');
          $ClientModel->terms   =  $terms;

          $ClientModel->next_follow_up_date = $request->next_follow_up_date;
          $ClientModel->admin_memo = $request->admin_memo;

          $ClientModel->currency_id = $request->currency;
          $currency = Currency::select('name')->where('id',$request->currency)->get()->value('name');
          $ClientModel->currency   =  $currency;

          if($request->opening_balance != '' && $request->opening_balance != null){
            $ClientModel->opening_balance = str_replace(',' ,'', $request->opening_balance);
          }else{
            $ClientModel->opening_balance = null;
          }

          $ClientModel->opening_balance_date = $request->opening_balance_date;
          $ClientModel->opening_balance_type = $request->opening_balance_type;

          if($request->has('user_image')){
                   
            $user_image = time().'.'.$request->user_image->extension();  
            $request->user_image->move(public_path('dash/user_image'), $user_image);
            $ClientModel->user_image = $user_image;

            if(is_file(public_path('dash/user_image').'/'.$old_user_image_name)){
                unlink(public_path('dash/user_image').'/'.$old_user_image_name);
            }
        }
          
          if($request->has('visiting_card_img')){
                   
            $visiting_card_img = time().'.'.$request->visiting_card_img->extension();  
            $request->visiting_card_img->move(public_path('dash/visiting_card_img'), $visiting_card_img);
            $ClientModel->visiting_card_img = $visiting_card_img;

            if(is_file(public_path('dash/visiting_card_img').'/'.$old_visiting_card_img_name)){
                unlink(public_path('dash/visiting_card_img').'/'.$old_visiting_card_img_name);
            }
        }

        if($request->has('company_logo')){
                   
            $company_logo = time().'.'.$request->company_logo->extension();  
            $request->company_logo->move(public_path('dash/company_logo'), $company_logo);
            $ClientModel->company_logo = $company_logo;

            if(is_file(public_path('dash/company_logo').'/'.$old_company_logo_name)){
                unlink(public_path('dash/company_logo').'/'.$old_company_logo_name);
            }
        }

        $ClientModel->storage_days = $request->storage_days;

        if($request->credit_limit != '' && $request->credit_limit != null){
            $ClientModel->credit_limit = str_replace(',' ,'', $request->credit_limit);
        }else{
            $ClientModel->credit_limit = null;
        }

        $ClientModel->bid_limitations = $request->bid_limitations;

        if($request->bid_amount_limit != '' && $request->bid_amount_limit != null){
            $ClientModel->bid_amount_limit = str_replace(',' ,'', $request->bid_amount_limit);
        }else{
            $ClientModel->bid_amount_limit = NULL;

        }
     
        $ClientModel->bid_limit_reason = $request->bid_limit_reason;
        $ClientModel->intial_payment_due_days = $request->intial_payment_due_days;         
        $ClientModel->bid = $request->bid;
        $ClientModel->bid_mail = $request->bid_mail;
        $ClientModel->sales_statistics = $request->sales_statistics;
        $ClientModel->auction = $request->auction;
        $ClientModel->uss = $request->uss;
        $ClientModel->uss_images = $request->uss_images;

          if($ClientModel->save()){
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
      
        if (!Auth::guard('dash')->user()->can('members-edit')) {
            abort(403);
        }

        $data = Client::where('id', $id)->first();
       
        // $data->association_member_id  = ( isset($data->messenger_1))?  json_decode($data->messenger_1): [];

       
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $countingArr = array();
        for($c=1; $c<=100; $c++){
            $countingArr[] = (Object) array('value'=> $c, 'name' => $c);
        }
        
        $country_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();

        $country = Country::select('id as value','name')->orderBy('name')->get();

        $port = Ports::select('id as value','name')->orderBy('name')->get();
        $religion = Religion::select('id as value','name')->orderBy('name')->get();
        $social_media = SocialMedia::select('id as value','name')->orderBy('name')->get();
        $sales_person = CompanySalesTeam::select('id as value' , 'name')->orderBy('name')->get();
        $rating = Rating::select('id as value','name')->orderBy('name')->get();
        // $stage = Stage::select('id as value','name')->orderBy('name')->get();
        $terms = Terms::select('id as value','name')->orderBy('name')->get();
        $currency = Currency::select('id as value','name')->orderBy('name')->get();

        return view('dash.content.members.create',['data'=>$data, 'breadcrumbs' => $breadcrumbs, 'port'=>$port,'country'=>$country, 'religion' => $religion, 'country_code'=>$country_code, 'social_media'=>$social_media, 'rating'=>$rating, 'terms'=>$terms, 'currency'=>$currency, 'countingArr'=>$countingArr, 'sales_person'=>$sales_person]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::guard('dash')->user()->can('members-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Client::find($request->id);
        if(is_file(public_path('dash/user_image').'/'.$data->user_image )){
            unlink(public_path('dash/user_image').'/'.$data->user_image);
        }

        if(is_file(public_path('dash/visiting_card_img').'/'.$data->visiting_card_img )){
            unlink(public_path('dash/visiting_card_img').'/'.$data->visiting_card_img);
        }

        if(is_file(public_path('dash/company_logo').'/'.$data->company_logo )){
            unlink(public_path('dash/company_logo').'/'.$data->company_logo);
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

        if (!Auth::guard('dash')->user()->can('members-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = Client::whereIn('id', $request->delete_ids)->get();
        
        foreach($data as $item){
            if(is_file(public_path('dash/user_image').'/'.$item->user_image )){
                unlink(public_path('dash/user_image').'/'.$item->user_image);
            }
            if(is_file(public_path('dash/visiting_card_img').'/'.$item->visiting_card_img )){
                unlink(public_path('dash/visiting_card_img').'/'.$item->visiting_card_img);
            }
            if(is_file(public_path('dash/company_logo').'/'.$item->company_logo )){
                unlink(public_path('dash/company_logo').'/'.$item->company_logo);
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
       
        if (!Auth::guard('dash')->user()->can('members-edit')) {
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