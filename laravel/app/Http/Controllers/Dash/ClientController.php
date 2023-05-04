<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dash\Client;
use App\Models\Masters\Country;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\Religion;
use App\Models\Ports;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='members';
    protected $status  =  [ 
        [ 'value' => 'Active', 'name'=> 'Active' ],
        [ 'value' => 'Deactive', 'name'=> 'Deactive' ]
    ];
 

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
        if( $request->has('search.status') && $request->input('search.status') != null ) {
            $members->StatusFilter($request->input('search.status')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $members->orderBy($request->order_by, $request->order);
        }
        
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        $members = $members->paginate($perPage);
        
        $status = json_decode(json_encode($this->status));

        return view('dash.content.members.index',['status' => $status, 'members'=>$members, 'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs]);
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

        $country = Country::select('id as value','name')->orderBy('name')->get();
        $port = Ports::select('id as value','name')->where('parent_id','0')->orderBy('name')->get();
        $religion = Religion::select('id as value','name')->where('parent_id','0')->orderBy('name')->get();
        // $cities = CityModel::select('id as value','name')->orderBy('name')->get();
        // $states = StateModel::select('id as value','name')->orderBy('name')->get();
        // $nationality = Netionality::select('id as value','name')->orderBy('name')->get();
        // $rating = Rating::select('id as value','name')->orderBy('name')->get();
        // $stage = Stage::select('id as value','name')->orderBy('name')->get();
        // $term = Term::select('id as value','name')->orderBy('name')->get();
        // $currency = Curremcy::select('id as value','name')->orderBy('name')->get();

        return view('dash.content.members.create',['breadcrumbs' => $breadcrumbs, 'country'=>$country, 'port'=>$port, 'religion'=>$religion]);
     }

     public function store(Request $request){  

        $old_visiting_card_img_name = '';

        if($request->id){
            if (!Auth::guard('dash')->user()->can('members-edit')) {
                abort(403);
            }

            $ClientModel =    Client::find($request->id);

            $old_visiting_card_img_name = $ClientModel->visiting_card_img;
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
            'status'        => 'required',
            'name'          => 'required|max:100',
            'company_name'  => 'required',
            'customer_uid'  => 'required|numeric',
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
            'birth_date'    => 'date',
            'anniversary_date'   => 'date',
            'next_follow_up_date'   => 'date',

            'sales_person'  => 'nullable|numeric',
            'rating'       => 'nullable|numeric',
            'stage'        => 'nullable|numeric',
            'term'         => 'nullable|numeric',
            'religion'      => 'nullable|numeric',
            'nationality'   => 'nullable|numeric',

            'opening_balance'  =>  'nullable|string|max:20',
            'opening_balance_date' => 'date',
            'currency'     => 'nullable|numeric',

            'facebook' => 'nullable|url|max:100',
            'instagram' => 'nullable|url|max:100',
            'twitter' => 'nullable|url|max:100',
            'linkedin' => 'nullable|url|max:100',

            'admin_memo'  =>  'nullable|string|max:250',

            'visiting_card_img'=> 'nullable|image|mimes:jpg,png,jpeg|max:5000',

            'registration_date'  => 'date',
            'registered_ip'  => 'nullable|string|max:50',
        ],
        [
            'title.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.title.title') ] ),
            'title.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.title.title') ] ),
            'company_name.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.company_name.title') ] ),
            'company_name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.company_name.title') ,"max" => "255"] ),
            'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
            'name.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),
            'customer_uid.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.customer_uid.title') ] ),
            'customer_uid.numeric' => __('webCaption.validation_numeric.title', ['field'=> __('webCaption.customer_uid.title') ] ),
            'status.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title') ] ),
            'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
            'mobile_1.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.mobile_1.title')] ),
            'mobile_1.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.mobile_1.title')] ),
            'mobile_1.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.mobile_1.title') ,"max" => "20"] ),
            'mobile_2.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.mobile_2.title')] ),
            'mobile_2.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.mobile_2.title') ,"max" => "20"] ),

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

            'birth_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.birth_date.title')] ),
            'anniversary_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.anniversary_date.title')] ),
            'next_follow_up_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.next_follow_up_date.title')] ),
            'opening_balance_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.opening_balance_date.title')] ),
            'registration_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.registration_date.title')] ),

            'opening_balance.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.opening_balance.title'), "max" => "20" ] ),
            'opening_balance.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.opening_balance.title') ] ),

            'email_1.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.email_1.title') ] ),
            'email_1.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email_1.title') ,"max" => "45"] ),
            'email_1.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email_1') ] ),
            'email_2.nullable'=> __('webCaption.validation_nullable.title', ['field'=> __('webCaption.email_2.title') ] ),
            'email_2.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email_2.title') ,"max" => "45"] ),
            'email_2.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email_2') ] ),

            'facebook.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.facebook.title')] ),
            'facebook.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.facebook.title') ,"max" => "100"] ),

            'instagram.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.instagram.title')] ),
            'instagram.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.instagram.title') ,"max" => "100"] ),

            'twitter.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.twitter.title')] ),
            'twitter.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.twitter.title') ,"max" => "100"] ),

            'linkedin.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.linkedin.title')] ),
            'linkedin.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.linkedin.title') ,"max" => "100"] ),

            'visiting_card_img.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.visiting_card_img.title')] ),
            'visiting_card_img.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.visiting_card_img.title'),"fileTypes" => "jpg,png,jpeg"] ),
            'visiting_card_img.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.visiting_card_img.title'),"max" => "5000"] ),
        ]);

        if(!isset($request->id)){
            $request->validate([
                'password' => 'required|min:8',   
            ],[
                'password.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.password.title') ] ),
                'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
            ]);
        }

        if($request->password != null){
            $ClientModel->password = $request->password ;
           }

          $ClientModel->status = $request->status;
          $ClientModel->title = $request->title;
          $ClientModel->name = $request->name;
          $ClientModel->company_name = $request->company_name;
          $ClientModel->customer_uid = $request->customer_uid;
          $ClientModel->email_1 = $request->email_1;
          $ClientModel->email_2 = $request->email_2;
          $ClientModel->mobile_1 = $request->mobile_1;
          $ClientModel->mobile_2 = $request->mobile_2;
          $ClientModel->address = $request->address;
          $ClientModel->city = $request->city;
          $ClientModel->state = $request->state;
          $ClientModel->country = $request->country;
          $ClientModel->port = $request->port;
          $ClientModel->zip_code = $request->zip_code;
          $ClientModel->religion = $request->religion;
          $ClientModel->nationality = $request->nationality;
          $ClientModel->birth_date = $request->birth_date;
          $ClientModel->anniversary_date = $request->anniversary_date;
          $ClientModel->facebook = $request->facebook;
          $ClientModel->instagram = $request->instagram;
          $ClientModel->twitter = $request->twitter;
          $ClientModel->linked_in = $request->linked_in;
          $ClientModel->sales_person = $request->sales_person;
          $ClientModel->rating = $request->rating;
          $ClientModel->stage = $request->stage;
          $ClientModel->term = $request->term;
          $ClientModel->broker = isset($request->broker)?"Yes":"No";
          $ClientModel->next_follow_up_date = $request->next_follow_up_date;
          $ClientModel->opening_balance = $request->opening_balance;
          $ClientModel->opening_balance_date = $request->opening_balance_date;
          $ClientModel->opening_balance_type = $request->opening_balance_type;
          $ClientModel->currency = $request->currency;
          if($request->has('visiting_card_img')){
                   
            $visiting_card_img = time().'.'.$request->visiting_card_img->extension();  
            $request->visiting_card_img->move(public_path('dash/visiting_card_img'), $visiting_card_img);
            $ClientModel->visiting_card_img = $visiting_card_img;

            if(is_file(public_path('dash/visiting_card_img').'/'.$old_visiting_card_img_name)){
                unlink(public_path('dash/visiting_card_img').'/'.$old_visiting_card_img_name);
            }
        }

          $ClientModel->admin_memo = $request->admin_memo;

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

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        
        $country = Country::select('id as value','name')->orderBy('name')->get();
        $port = Ports::select('id as value','name')->where('parent_id','0')->orderBy('name')->get();
        $religion = Religion::select('id as value','name')->where('parent_id','0')->orderBy('name')->get();
        // $cities = CityModel::select('id as value','name')->orderBy('name')->get();
        // $states = StateModel::select('id as value','name')->orderBy('name')->get();
        // $nationality = Netionality::select('id as value','name')->orderBy('name')->get();
        // $rating = Rating::select('id as value','name')->orderBy('name')->get();
        // $stage = Stage::select('id as value','name')->orderBy('name')->get();
        // $term = Term::select('id as value','name')->orderBy('name')->get();
        // $currency = Curremcy::select('id as value','name')->orderBy('name')->get();

        return view('dash.content.members.create',['data'=>$data, 'breadcrumbs' => $breadcrumbs, 'port'=>$port,'country' => $country, 'religion' => $religion ]);
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
        if(is_file(public_path('dash/visiting_card_img').'/'.$data->visiting_card_img )){
            unlink(public_path('dash/visiting_card_img').'/'.$data->visiting_card_img);
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
            if(is_file(public_path('dash/visiting_card_img').'/'.$item->visiting_card_img )){
                unlink(public_path('dash/visiting_card_img').'/'.$item->visiting_card_img);
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