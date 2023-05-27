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

            $salesData['company_id'] = $companyId;
            $salesData['company_user_id'] = $companyUserModel->id;
            $salesData['title'] = $request->title;
            $salesData['name'] = $request->name;
            $salesData['email'] = $request->email;
            $salesData['status'] = $request->status;

            //Departement
            $salesData['department_id'] = $request->department_id;
            if(isset($request->department_id) && !empty($request->department_id)){
                $department  = Department::select('name')->where('id', $request->department_id)->get()->value('name'); 
                $salesData['department'] = $department;
            }else $salesData['department'] = NULL;
            
            if(isset($request->password) && !empty($request->password)) $salesData['password'] = bcrypt($request->password);

            //Designation
            $salesData['designation_id'] = $request->designation_id;
            if(isset($request->designation_id) && !empty($request->designation_id)){   
                $designation  = Designation::select('name')->where('id', $request->designation_id)->get()->value('name'); 
                $salesData['designation'] = $designation;
            }else $salesData['designation'] = NULL;

            if($request->has('roles')) {
                if(is_array($request->roles) && count($request->roles) > 0){
                    $roles = json_encode($request->roles);

                    $salesData['roles_id'] = $roles;
                    
                    $roles_name = Roles::select('name')->where('name','!=',null)->whereIn('id', $request->roles)->get()->toArray();
                    $roles_name = (empty($roles_name))? null: implode(',', array_column($roles_name,'name'));
                    
                    $salesData['roles'] = $roles_name;

                }    
            }else{
                $salesData['roles_id'] = NULL;
                $salesData['roles'] = NULL;
            }
            
            if(isset($request->verification) && !empty($request->verification)) $salesData['verification'] = $request->verification;
            else $salesData['verification'] = '0';
            
            $salesData['admin_memo'] = $request->admin_memo;
            $salesData['company_address'] = $request->company_address;

            //Company Country
            $salesData['company_country_id'] = $request->company_country;
            if(isset($request->company_country) && !empty($request->company_country)){    
                $company_country  = Country::select('name')->where('id', $request->company_country)->get()->value('name'); 
                $salesData['company_country'] = $company_country;
            } else $salesData['company_country'] = NULL;
            

            //Company State
            $salesData['company_state_id'] = $request->company_state;
            if(isset($request->company_state) && !empty($request->company_state)){
                $company_state  = StateModel::select('name')->where('id', $request->company_state)->get()->value('name'); 
                $salesData['company_state'] = $company_state;
            }else $salesData['company_state'] = NULL;

            //Company City
            $salesData['company_city_id'] = $request->company_city;
            if(isset($request->company_city) && !empty($request->company_city)){
                $company_city  = CityModel::select('name')->where('id', $request->company_city)->get()->value('name'); 
                $salesData['company_city'] = $company_city;
            } else $salesData['company_city'] = NULL;

            $salesData['company_zip_code'] = $request->company_zip_code;

            if(isset($request->company_phone) && !empty($request->company_phone) && !empty($request->company_country_code)){ $salesData['company_phone'] = $request->company_country_code."_".$request->company_phone; 
            }else{
                $salesData['company_phone'] = NULL;
            }
          
            if($request->has('company_messenger')) {
                $company_messenger = [];
                foreach($request->company_messenger as $key=>$value){
                    $company_messenger_name = Messenger::where('name','!=',null)->where('id',$value)->get()->value('name');
                    
                    $company_messenger[$key]['id'] = $value;
                    $company_messenger[$key]['value']= $company_messenger_name;
                }    
                $salesData['company_messenger'] = json_encode($company_messenger);
            }else{
                $salesData['company_messenger'] =  NULL;
            }
            
            if($request->has('language')) {
                $language = json_encode($request->language);
                $salesData['language_id'] =  $language;
                
                $language_name = Language::select('name')->where('name','!=',null)->whereIn('id',$request->language)->get()->toArray();
                $language_name = (empty($language_name))? null: implode(',', array_column( $language_name,'name' ));
                
                $salesData['language_name'] = $language_name;
            }else{
                $salesData['language_id'] = NUll;
                $salesData['language_name'] =  NULL;
            }

            $salesData['current_address'] = $request->current_address;

            //Current Country
            $salesData['current_country_id'] = $request->current_country;
            if(isset($request->current_country) && !empty($request->current_country)){
                $current_country  = Country::select('name')->where('id', $request->current_country)->get()->value('name'); 
                $salesData['current_country'] = $current_country;
            } else $salesData['current_country'] = NULL;

            //Current State
            $salesData['current_state_id'] = $request->current_state;
            if(isset($request->current_state) && !empty($request->current_state)){
                $current_state  = StateModel::select('name')->where('id', $request->current_state)->get()->value('name'); 
                $salesData['current_state'] = $current_state;
            } else $salesData['current_state'] = NULL;
            

            //Current City
            $salesData['current_city_id'] = $request->current_city;
            if(isset($request->current_city) && !empty($request->current_city)){
                $current_city  = CityModel::select('name')->where('id', $request->current_city)->get()->value('name'); 
                $salesData['current_city'] = $current_city;
            } else $salesData['current_city'] = NULL;

            $salesData['current_zip_code'] = $request->current_zip_code;
            
            if(isset($request->same_as_current) && !empty($request->same_as_current)) $salesData['same_as_current'] = $request->same_as_current;
            else $salesData['same_as_current'] = '0';

            $salesData['permanent_address'] = $request->permanent_address;
            
            //Permanent Country
            $salesData['permanent_country_id'] = $request->permanent_country;
            if(isset($request->permanent_country) && !empty($request->permanent_country)){
                $permanent_country  = Country::select('name')->where('id', $request->permanent_country)->get()->value('name'); 
                $salesData['permanent_country'] = $permanent_country;
            } else $salesData['permanent_country'] = NULL;
            
            //Permanent State
            $salesData['permanent_state_id'] = $request->permanent_state;
            if(isset($request->permanent_state) && !empty($request->permanent_state)){
                $permanent_state  = StateModel::select('name')->where('id', $request->permanent_state)->get()->value('name'); 
                $salesData['permanent_state'] = $permanent_state;
            } else $salesData['permanent_state'] = NULL;

            //Permanent City
            $salesData['permanent_city_id'] = $request->permanent_city;
            if(isset($request->permanent_city) && !empty($request->permanent_city)){
                $permanent_city = CityModel::select('name')->where('id', $request->permanent_city)->get()->value('name'); 
                $salesData['permanent_city'] = $permanent_city;
            } else $salesData['permanent_city'] = NULL;
            
            $salesData['permanent_zip_code'] = $request->permanent_zip_code;

            //Phone
            if(isset($request->personal_phone) && !empty($request->personal_phone) && !empty($request->personal_country_code)){
                $salesData['personal_phone'] = $request->personal_country_code."_".$request->personal_phone;
            }
            else{
                $salesData['personal_phone'] = NULL;
            }

            //Personal Messenger
            if($request->has('personal_messenger')) {
                $personal_messenger = [];
                foreach($request->personal_messenger as $key=>$value){
                    $personal_messenger_name = Messenger::where('name','!=',null)->where('id',$value)->get()->value('name');
                    
                    $personal_messenger[$key]['id'] = $value;
                    $personal_messenger[$key]['value']= $personal_messenger_name;
                }    
                $salesData['personal_messenger'] = json_encode($personal_messenger);    
            }else{
                $salesData['personal_messenger'] = NULL;
            }
            
            //religion
            $salesData['religion_id'] = $request->religion;
            if(isset($request->religion) && !empty($request->religion)){
                $religion  = Religion::select('name')->where('id', $request->religion)->get()->value('name');
                $salesData['religion'] = $religion;
            }else $salesData['religion'] = NULL;

            $salesData['anniversary_date'] = $request->anniversary_date;
            $salesData['dob'] = $request->dob;
            
            //Image
            if($request->has('image') && !empty($request->image)){
                $image = time().'.'.$request->image->extension();  
                $request->image->move(public_path('dash').'/sales_team', $image);
                $salesData['image'] = $image;
            }else{
                $salesData['image'] = NULL;
            }

            //Social Media
            if(is_array($request->social_media) && count($request->social_media)>0){
                $socialArr = array();
                foreach($request->social_media as $key=>$value){
                $social_name  = SocialMedia::select('name')->where('id', $value)->get()->value('name'); 
                    $socialArr[$key]['id'] = $value;
                    $socialArr[$key]['name'] = $social_name;
                    $socialArr[$key]['value'] = $request->social_value[$key];
                }
                $salesData['company_social_media'] = json_encode($socialArr);
            }else{
                $salesData['company_social_media'] = NULL;
            }
           
            // Update & Insert
            if(isset($request->id) && !empty($request->id)){ 
                $company_sales_team_data = CompanySalesTeam::where('company_user_id', $request->id)->first();
                $companyUserModel->permissions()->sync($request->permissions);
                $salesData['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();

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
        
        $companySales_Data = CompanySalesTeam::whereIn('company_user_id', $request->delete_ids)->first();
        if(isset($companySales_Data->image) && !empty($companySales_Data->image)){
            if(is_file(public_path('dash').'/sales_team'.'/'.$companySales_Data->image )){
                unlink(public_path('dash').'/sales_team'.'/'.$companySales_Data->image);
            }
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
