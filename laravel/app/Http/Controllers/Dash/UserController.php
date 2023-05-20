<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyUserPermission;
use App\Models\Dash\CompanyUsers;
use App\Models\Dash\CompanySalesTeam;
use App\Models\Dash\CompanySalesTeamSocialMedia;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Masters\User\Department;
use App\Models\Masters\User\Designation;
use App\Models\Masters\Country;
use App\Models\Masters\Language;
use App\Models\Masters\SocialMedia;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\Religion;
use App\Models\Masters\Company\Messenger;
use App\Models\Masters\Company\Roles;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{   

    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='users';
    protected $status  =  [ 
        [ 'value' => 'Permitted', 'name'=> 'Permitted' ],
        [ 'value' => 'Blocked', 'name'=> 'Blocked' ]
    ];
 

    public function __construct(UrlGenerator $url)
    {   
        $this->url = $url;
        $this->baseUrl = $this->url->to('users');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {   
        if (!Auth::guard('dash')->user()->can('common-users')) {
            abort(403);
        }

        
        $companyId =  Auth::guard('dash')->user()->company_id; 
        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::guard('dash')->user()->can('common-users-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        }        

        $users = CompanyUsers::select('*')->where('user_type','!=','1')->where('company_id',$companyId);

        if( $request->has('search.keyword')) {
            $users->keywordFilter($request->input('search.keyword')); 
        }
        if( $request->has('search.status') && $request->input('search.status') != null ) {
            $users->StatusFilter($request->input('search.status')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $users->orderBy($request->order_by, $request->order);
        }
        
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;
        $users = $users->paginate($perPage);
        $status = json_decode(json_encode($this->status));
        return view('dash.content.users.index',['status' => $status,'users' => $users,'pageConfigs' =>$pageConfigs ,'breadcrumbs' => $breadcrumbs]);
    }


    public function loginFromAdmin(Request $request){
     
        $id = Crypt::decrypt($request->id);
        $user  = CompanyUsers::where('id',$id)->first();
        
        if($user){
            auth()->guard('dash')->logout();
            Session::flush();
            Auth::guard('dash')->login($user);
            return redirect('/dashboard');
        }else{
            $message = __('webCaption.user_not_found.title'); 
            return redirect()->back()->with(['error_message' => $message ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (!Auth::guard('dash')->user()->can('common-users-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        
        $status = json_decode(json_encode($this->status));
        $permissions  = Auth::guard('dash')->user()->permissions->where('parent_id',0);

        $department  = Department::select('id as value','name')->orderBy('name')->get();
        $designation = Designation::select('id as value','name')->orderBy('name')->get();
        $country     = Country::select('id as value','name')->orderBy('name')->get();
        $language    = Language::select('id as value','name')->orderBy('name')->get();
        $religion    = Religion::select('id as value','name')->orderBy('name')->get();
        $socialMedia = SocialMedia::select('id as value','name')->orderBy('name')->get();
        $roles = Roles::select('id as value','name')->orderBy('name')->get();
        $country_phone_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();
        
        return view('dash.content.users.create',['permissions' => $permissions,'breadcrumbs' => $breadcrumbs ,'status' => $status, 'department' => $department, 'designation' => $designation, 'country' => $country,'language' => $language, 'religion' => $religion, 'social_media' => $socialMedia, 'roles' => $roles, 'country_code' => $country_phone_code]);
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
            if (!Auth::guard('dash')->user()->can('common-users-edit')) {
                abort(403);
            }
            $companyUserModel =    CompanyUsers::find($request->id);
        }else{
            if (!Auth::guard('dash')->user()->can('common-users-add')) {
                abort(403);
            }
            $companyUserModel = new CompanyUsers();
        }

        $userPermission  =  Auth::guard('dash')->user()->permissions;
        $userPermission  = array_column(json_decode(json_encode($userPermission), true),'id');
        $givenPermission = $request->permissions;

        // this condation  is check the permission array was come is belong or not  user permissions array
        if(($givenPermission != null)  &&  !(array_intersect($givenPermission, $userPermission) === $givenPermission)) {  abort(403); } 
   
       $companyId =  Auth::guard('dash')->user()->company_id;  
        
      
        $request->validate([
            'name'               => 'required',
            'email'              => 'required|email|unique:company_users,email,'.$request->id,
            'status'             => 'required',
            'password'           => 'nullable|confirmed|min:8',
            'designation_id'     => 'required|numeric',
            'department_id'      => 'required|numeric',
            'company_phone'      => 'required|numeric',
            'personal_phone'     => 'nullable|numeric',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'company_zip_code'   => 'nullable|numeric',
            'permanent_zip_code' => 'nullable|numeric',
            "company_country_code" => "required_with:telephone",
            "personal_country_code" => "required_with:telephone",

        ],[
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
            'email.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title')] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> __('webCaption.email.title') ] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'status.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title') ] ),
            'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
            'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> __('webCaption.password.title') ] ),
            'designation_id.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.designation.title') ] ),
            'designation_id.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.designation.title') ] ),
            'department_id.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.department.title') ] ),
            'department_id.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.department.title') ] ),
            'company_phone.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.phone.title') ] ),
            'company_phone.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
            'company_country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),
            'personal_phone.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.phone.title') ] ),
            'personal_phone.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
            'personal_country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),
            'image.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.image.title') ] ),
            'image.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.image.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'image.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.image.title') ,"max" => "5000"] ),
          ]);
           
        if(!isset($request->id)){
            $request->validate([
                'password' => 'required|confirmed|min:8',   
            ],[
                'password.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.password.title') ] ),
                'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
                'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> __('webCaption.password.title') ] ),
            ]);
        }
       
        if($request->password != null){
             $companyUserModel->password = bcrypt($request->password);
        }
        $companyUserModel->email = $request->email;
        $companyUserModel->name = $request->name;
        $companyUserModel->user_type = 2;  //2 for user role 
        $companyUserModel->status = $request->status;
        $companyUserModel->company_id = $companyId;
        
        if($companyUserModel->save()){   
            
            $company_sales_team = new CompanySalesTeam;
            $salesData = array();
        
            //Store Sales Team Data
            if(isset($companyId) && !empty($companyId)) $salesData['company_id'] = $companyId;

            if(isset($companyUserModel->id) && !empty($companyUserModel->id)) $salesData['company_user_id'] = $companyUserModel->id;
            
            if(isset($request->title) && !empty($request->title)) $salesData['title'] = $request->title;

            if(isset($request->name) && !empty($request->name)) $salesData['name'] = $request->name;

            if(isset($request->department_id) && !empty($request->department_id)){ 
                $salesData['department_id'] = $request->department_id;
                $department  = Department::select('name')->where('id', $request->department_id)->get()->value('name'); 
                $salesData['department'] = $department;
            }

            if(isset($request->email) && !empty($request->email)) $salesData['email'] = $request->email;
            
            if(isset($request->password) && !empty($request->password)) $salesData['password'] = bcrypt($request->password);

            if(isset($request->designation_id) && !empty($request->designation_id)){ 
                $salesData['designation_id'] = $request->designation_id;
                $designation  = Designation::select('name')->where('id', $request->designation_id)->get()->value('name'); 
                $salesData['designation'] = $designation;
            }

            if(isset($request->designation_id) && !empty($request->designation_id)){ 
                $salesData['designation_id'] = $request->designation_id;
                $designation  = Designation::select('name')->where('id', $request->designation_id)->get()->value('name'); 
                $salesData['designation'] = $designation;
            }

            /* if(isset($request->roles) && !empty($request->roles)){ 
                $salesData['roles_id'] = $request->roles;
                $roles  = Roles::select('name')->where('id', $request->roles)->get()->value('name'); 
                $salesData['roles'] = $roles;
            } */

            if($request->has('roles')) {
                if(is_array($request->roles) && count($request->roles) > 0){
                    $roles = json_encode($request->roles);

                    $salesData['roles_id'] = $roles;
                    
                    $roles_name = Roles::select('name')->where('name','!=',null)->whereIn('id', $request->roles)->get()->toArray();
                    $roles_name = (empty($roles_name))? null: implode(',', array_column($roles_name,'name'));
                    
                    $salesData['roles'] = $roles_name;

                }    
            } 
            if(isset($request->status) && !empty($request->status) && $request->status != NULL) $salesData['status'] = $request->status;
            
            if(isset($request->verification) && !empty($request->verification)) $salesData['verification'] = $request->verification;
            else $salesData['verification'] = '0';
            
            if(isset($request->admin_memo) && !empty($request->admin_memo)) $salesData['admin_memo'] = $request->admin_memo;
            
            if(isset($request->company_address) && !empty($request->company_address)) $salesData['company_address'] = $request->company_address;

            if(isset($request->company_country) && !empty($request->company_country)){ 
                $salesData['company_country_id'] = $request->company_country;
                $company_country  = Country::select('name')->where('id', $request->company_country)->get()->value('name'); 
                $salesData['company_country'] = $company_country;
            }

            if(isset($request->company_state) && !empty($request->company_state)){ 
                $salesData['company_state_id'] = $request->company_state;
                $company_state  = StateModel::select('name')->where('id', $request->company_state)->get()->value('name'); 
                $salesData['company_state'] = $company_state;
            }

            if(isset($request->company_city) && !empty($request->company_city)){ 
                $salesData['company_city_id'] = $request->company_city;
                $company_city  = CityModel::select('name')->where('id', $request->company_city)->get()->value('name'); 
                $salesData['company_city'] = $company_city;
            }

            if(isset($request->company_zip_code) && !empty($request->company_zip_code)) $salesData['company_zip_code'] = $request->company_zip_code;

            if(isset($request->company_phone) && !empty($request->company_phone) && !empty($request->company_country_code)) $salesData['company_phone'] = $request->company_country_code."_".$request->company_phone;
            
            if($request->has('company_messenger')) {
                if(is_array($request->company_messenger) && count($request->company_messenger) > 0){
                    $company_messenger = json_encode($request->company_messenger);
                    
                    $salesData['company_messenger_id'] = $company_messenger;
                    
                    $company_messenger_name = Messenger::select('name')->where('name','!=',null)->whereIn('id',$request->company_messenger)->get()->toArray();
                    $company_messenger_name = (empty($company_messenger_name))? null: implode(',', array_column( $company_messenger_name,'name' ));
                    
                    $salesData['company_messenger_name'] = $company_messenger_name;
                }    
            }  
            
            if($request->has('language')) {
                if(is_array($request->language) && count($request->language) > 0){
                    $language = json_encode($request->language);

                    $salesData['language_id'] =  $language;
                    
                    $language_name = Language::select('name')->where('name','!=',null)->whereIn('id',$request->language)->get()->toArray();
                    $language_name = (empty($language_name))? null: implode(',', array_column( $language_name,'name' ));
                    
                    $salesData['language_name'] = $language_name;

                }    
            }  

            if(isset($request->current_address) && !empty($request->current_address)) $salesData['current_address'] = $request->current_address;

            if(isset($request->current_country) && !empty($request->current_country)){ 
                $salesData['current_country_id'] = $request->current_country;
                $current_country  = Country::select('name')->where('id', $request->current_country)->get()->value('name'); 
                $salesData['current_country'] = $current_country;
            }

            if(isset($request->current_state) && !empty($request->current_state)){ 
                $salesData['current_state_id'] = $request->current_state;
                $current_state  = StateModel::select('name')->where('id', $request->current_state)->get()->value('name'); 
                $salesData['current_state'] = $current_state;
            }

            if(isset($request->current_city) && !empty($request->current_city)){ 
                $salesData['current_city_id'] = $request->current_city;
                $current_city  = CityModel::select('name')->where('id', $request->current_city)->get()->value('name'); 
                $salesData['current_city'] = $current_city;
            }

            if(isset($request->current_zip_code) && !empty($request->current_zip_code)) $salesData['current_zip_code'] = $request->current_zip_code;
            
            if(isset($request->same_as_current) && !empty($request->same_as_current)) $salesData['same_as_current'] = $request->same_as_current;
            else $salesData['same_as_current'] = '0';

            if(isset($request->permanent_address) && !empty($request->permanent_address)) $salesData['permanent_address'] = $request->permanent_address;

            if(isset($request->permanent_country) && !empty($request->permanent_country)){ 
                $salesData['permanent_country_id'] = $request->permanent_country;
                $permanent_country  = Country::select('name')->where('id', $request->permanent_country)->get()->value('name'); 
                $salesData['permanent_country'] = $permanent_country;
            }
        
            if(isset($request->permanent_state) && !empty($request->permanent_state)){ 
                $salesData['permanent_state_id'] = $request->permanent_state;
                $permanent_state  = StateModel::select('name')->where('id', $request->permanent_state)->get()->value('name'); 
                $salesData['permanent_state'] = $permanent_state;
            }

            if(isset($request->permanent_city) && !empty($request->permanent_city)){ 
                $salesData['permanent_city_id'] = $request->permanent_city;
                $permanent_city  = CityModel::select('name')->where('id', $request->permanent_city)->get()->value('name'); 
                $salesData['permanent_city'] = $permanent_city;
            }
            
            if(isset($request->permanent_zip_code) && !empty($request->permanent_zip_code)) $salesData['permanent_zip_code'] = $request->permanent_zip_code;

            if(isset($request->personal_phone) && !empty($request->personal_phone) && !empty($request->personal_country_code)) $salesData['personal_phone'] = $request->personal_country_code."_".$request->personal_phone;
            
            if($request->has('personal_messenger')) {
                if(is_array($request->personal_messenger) && count($request->personal_messenger) > 0){
                    $personal_messenger = json_encode($request->personal_messenger);
                    
                    $salesData['personal_messenger_id'] = $personal_messenger;
                    
                    $personal_messenger_name = Messenger::select('name')->where('name','!=',null)->whereIn('id',$request->personal_messenger)->get()->toArray();
                    $personal_messenger_name = (empty($personal_messenger_name))? null: implode(',', array_column( $personal_messenger_name,'name' ));
                    
                    $salesData['personal_messenger_name'] = $personal_messenger_name;
                }    
            } 
            
            if(isset($request->religion) && !empty($request->religion)){ 
                $salesData['religion_id'] = $request->religion;
                $religion  = Religion::select('name')->where('id', $request->religion)->get()->value('name');
                $salesData['religion'] = $religion;
            }

            if(isset($request->anniversary_date) && !empty($request->anniversary_date)) $salesData['anniversary_date'] = $request->anniversary_date;
            
            if(isset($request->dob) && !empty($request->dob)) $salesData['dob'] = $request->dob;
            
            if($request->has('image') && !empty($request->image)){
                $image = time().'.'.$request->image->extension();  
                $request->image->move(public_path('dash').'/sales_team', $image);
                $salesData['image'] = $image;
            }

            if(is_array($request->social_media) && count($request->social_media)>0){
                $socialArr = array();
                foreach($request->social_media as $key=>$value){
                $social_name  = SocialMedia::select('name')->where('id', $value)->get()->value('name'); 
                    $socialArr[$key]['id'] = $value;
                    $socialArr[$key]['name'] = $social_name;
                    $socialArr[$key]['value'] = $request->social_value[$key];
                }
                $salesData['company_social_media'] = json_encode($socialArr);
            }
           
            //echo "<pre>"; print_r($salesData); echo "</pre>"; exit;
        
            if(isset($request->id) && !empty($request->id)){ 
               $company_sales_team_data = CompanySalesTeam::where('company_user_id', $request->id)->first();
                $companyUserModel->permissions()->sync($request->permissions);
                $salesData['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();
                //echo "<pre>"; print_r($salesData); echo "</pre>"; exit;
                $company_sales_team_data->update($salesData);
                
            $message = $request->name." ". __('webCaption.alert_updated_successfully.title');
            }                 
            else{

                $salesData['created_at'] =  \Carbon\Carbon::now()->toDateTimeString();
                $salesData['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();
                //Insert Permission Code
                $companyUserModel->permissions()->attach($request->permissions);
                //Insert Data in the Company Sales Team Table
                $company_sales_team_insert_id = $company_sales_team->insert($salesData);

                $message =  $request->name." ". __('webCaption.alert_added_successfully.title');

                
            }
            return redirect()->route('dashusers.index')->with('success_message', $message);

        }else{
            return redirect()->route('dashusers.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::guard('dash')->user()->can('common-users-edit')) {
            abort(403);
        }

        $user = CompanyUsers::with('companySalesTeam')->find($id);
 
        //to be continue
        $socialMedia = CompanySalesTeam::with('salesSocialMedia')->where('company_user_id',$user->companySalesTeam->company_user_id)->first();
        
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        // $permissions = CompanyMenuGroupMenu::where('parent_id', 0)->get();
        $permissions  = Auth::guard('dash')->user()->permissions->where('parent_id',0);
        
        $department  = Department::select('id as value','name')->orderBy('name')->get();
        $designation = Designation::select('id as value','name')->orderBy('name')->get();
        $country     = Country::select('id as value','name')->orderBy('name')->get();
        $language    = Language::select('id as value','name')->orderBy('name')->get();
        $religion    = Religion::select('id as value','name')->orderBy('name')->get();
        $social_media = SocialMedia::select('id as value','name')->orderBy('name')->get();
        $roles = Roles::select('id as value','name')->orderBy('name')->get();
        $country_phone_code =  Country::select('phone_code as value' ,'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();

        $status = json_decode(json_encode($this->status));
        return view('dash.content.users.create',['permissions' => $permissions ,'user' => $user ,'breadcrumbs' => $breadcrumbs ,'status' => $status, 'department' => $department, 'designation' => $designation, 'country' => $country, 'language' => $language, 'religion' => $religion, 'social_media' => $social_media, 'socialMedia' => $socialMedia, 'roles' => $roles, 'country_code' => $country_phone_code]);
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
        if (!Auth::guard('dash')->user()->can('common-users-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        CompanyUserPermission::where('company_user_id', $request->id)->delete();
        

        $company_sales_team_data =  CompanySalesTeam::where('company_user_id',$request->id)->first();
        if(isset($company_sales_team_data->image) && !empty($company_sales_team_data->image)){
            if(is_file(public_path('dash').'/sales_team'.'/'.$company_sales_team_data->image )){
                unlink(public_path('dash').'/sales_team'.'/'.$company_sales_team_data->image);
            }
            CompanySalesTeam::where('id',$company_sales_team_data->id)->delete();
        }

        if(CompanyUsers::where('id', $request->id)->delete()){
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

        
        if (!Auth::guard('dash')->user()->can('common-users-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

            CompanyUserPermission::whereIn('company_user_id', $request->delete_ids)->delete();
        
    $company_sales_team_data = CompanySalesTeam::whereIn('company_user_id', $request->delete_ids)->first();
        if(isset($company_sales_team_data->image) && !empty($company_sales_team_data->image)){
            if(is_file(public_path('dash').'/sales_team'.'/'.$company_sales_team_data->image )){
                unlink(public_path('dash').'/sales_team'.'/'.$company_sales_team_data->image);
            }
            CompanySalesTeam::whereIn('id',$company_sales_team_data->id)->delete();
        }
                   
           if(CompanyUsers::whereIn('id', $request->delete_ids)->delete()){
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
