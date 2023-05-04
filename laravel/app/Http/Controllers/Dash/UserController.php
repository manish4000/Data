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
        
        return view('dash.content.users.create',['permissions' => $permissions,'breadcrumbs' => $breadcrumbs ,'status' => $status, 'department' => $department, 'designation' => $designation, 'country' => $country,'language' => $language, 'religion' => $religion, 'social_media' => $socialMedia]);
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
            'name'          => 'required',
            'email'         => 'required|email|unique:company_users,email,'.$request->id,
            'status'        => 'required',
            // 'username' =>  'required|unique:company_users,username,'.$request->id,
            'password'      => 'nullable|confirmed|min:8',
            'designation'   => 'required',
            'department'    => 'required',
            'phone_1'       => 'required|numeric',
            'phone_2'       => 'nullable|numeric',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
           // 'social_value'  => 'nullable|url|max:100',
            'local_zip_code' => 'nullable|numeric',
            'permanent_zip_code' => 'nullable|numeric',

        ],[
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title') ] ),
            'email.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title')] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> __('webCaption.email.title') ] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'status.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title') ] ),
            'password.min' => __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,'min' => "8"] ),
            'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> __('webCaption.password.title') ] ),
            'designation.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.designation.title') ] ),
            'department.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.department.title') ] ),
            'phone_1.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.phone_1.title') ] ),
            'phone_1.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.phone_1.title') ,"max" => "20"] ),
            'phone_2.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.phone_2.title') ] ),
            'phone_2.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.phone_2.title') ,"max" => "20"] ),
            'image.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.image.title') ] ),
            'image.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.image.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'image.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.image.title') ,"max" => "6120"] ),
            'social_value.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.value.title')] ),
            'social_value.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.value.title') ,"max" => "100"] ),
            'local_zip_code.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.local_zip_code.title') ] ),
            'permanent_zip_code.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.permanent_zip_code.title') ] ),
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
        $company_sales_team_social_media  = new CompanySalesTeamSocialMedia;
        $salesData = array();
        if($request->has('language')) {
            if(is_array($request->language) && count($request->language) > 0){
                $language   = json_encode($request->language);
                $language_name = Language::select('name')->where('name','!=',null)->whereIn('id',$request->language)->get()->toArray();
                $language_name = (empty($language_name))? null: implode(',', array_column( $language_name,'name' ));
            }    
        }  

        if(isset($companyId) && !empty($companyId)) $salesData['company_id'] = $companyId;
        if(isset($companyUserModel->id) && !empty($companyUserModel->id)) $salesData['company_user_id'] = $companyUserModel->id;
        if(isset($request->name) && !empty($request->name)) $salesData['name'] = $request->name;
        if(isset($request->email) && !empty($request->email)) $salesData['email'] = $request->email;
        if(isset($request->password) && !empty($request->password)) $salesData['password'] = bcrypt($request->password);
        if(isset($request->status) && !empty($request->status) && $request->status != NULL) $salesData['status'] = $request->status;
        //$salesData['status'] = "Active";
        if(isset($request->department) && !empty($request->department)){ 
            $salesData['department_id'] = $request->department;
            $department  = Department::select('name')->where('id', $request->department)->get()->value('name'); 
            $salesData['department'] = $department;
        }
        if(isset($request->designation) && !empty($request->designation)){ 
            $salesData['designation_id'] = $request->designation;
            $designation  = Designation::select('name')->where('id', $request->designation)->get()->value('name'); 
            $salesData['designation'] = $designation;
        }
        if(isset($request->two_step_verification) && !empty($request->two_step_verification)) $salesData['two_step_verification'] = $request->two_step_verification;

        if(isset($request->local_address) && !empty($request->local_address)) $salesData['local_address'] = $request->local_address;

        if(isset($request->local_country) && !empty($request->local_country)){ 
            $salesData['local_country_id'] = $request->local_country;
            $local_country  = Country::select('name')->where('id', $request->local_country)->get()->value('name'); 
            $salesData['local_country'] = $local_country;
        }

        if(isset($request->local_state) && !empty($request->local_state)){ 
            $salesData['local_state_id'] = $request->local_state;
            $local_state  = StateModel::select('name')->where('id', $request->local_state)->get()->value('name'); 
            $salesData['local_state'] = $local_state;
        }

        if(isset($request->local_city) && !empty($request->local_city)){ 
            $salesData['local_city_id'] = $request->local_city;
            $local_city  = CityModel::select('name')->where('id', $request->local_city)->get()->value('name'); 
            $salesData['local_city'] = $local_city;
        }

        if(isset($request->local_zip_code) && !empty($request->local_zip_code)) $salesData['local_zip_code'] = $request->local_zip_code;
        
        if(isset($request->same_as_local) && !empty($request->same_as_local)) $salesData['same_as_local'] = $request->same_as_local;

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

        if(isset($request->phone_1) && !empty($request->phone_1)) $salesData['phone_1'] = $request->phone_1;
        if(isset($request->phone_2) && !empty($request->phone_2)) $salesData['phone_2'] = $request->phone_2;
        if(isset($request->skype) && !empty($request->skype)) $salesData['skype'] = $request->skype;
        if(isset($request->language) && !empty($request->language)) $salesData['language_id'] = json_encode($request->language);
        if(isset($language_name) && !empty($language_name)) $salesData['language_name'] = $language_name;
        
        if(isset($request->religion) && !empty($request->religion)){ 
            $salesData['religion_id'] = $request->religion;
            $religion  = Religion::select('name')->where('id', $request->religion)->get()->value('name');
            $salesData['religion'] = $religion;
        }

        if(isset($request->anniversary_date) && !empty($request->anniversary_date)) $salesData['anniversary_date'] = $request->anniversary_date;
        if(isset($request->dob) && !empty($request->dob)) $salesData['dob'] = $request->dob;
        if(isset($request->gender) && !empty($request->gender)) $salesData['gender'] = $request->gender;
        
        if($request->has('image') && !empty($request->image)){
            $image = time().'.'.$request->image->extension();  
            $request->image->move(public_path('dash').'/sales_team', $image);
            $salesData['image'] = $image;
        }
        
        if(isset($request->id) && !empty($request->id)){ 
            $company_sales_team_data = CompanySalesTeam::where('company_user_id', $request->id)->first();
            //$sales_team_social_media_data = CompanySalesTeamSocialMedia::where('company_sales_team_id', $company_sales_team_data->id)->get();
            $companyUserModel->permissions()->sync($request->permissions);
            $salesData['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();
            $check = $company_sales_team_data->update($salesData);

            if($check > 0){  
            if(CompanySalesTeamSocialMedia::where('company_sales_team_id', $company_sales_team_data->id)->delete()){
               foreach($request->social_media as $key=>$value){
                    $socialMedia['company_user_id'] = $companyUserModel->id;
                    $socialMedia['company_sales_team_id'] = $company_sales_team_data->id;
                    $socialMedia['social_media_id'] = $value;
                    $socialMedia['value'] = $request->social_value[$key];
                    $socialMedia['created_at'] =  \Carbon\Carbon::now()->toDateTimeString();
                    $socialMedia['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString(); 
                    //Update Data in the Sales Team Social Media Table
                    
                    $company_sales_team_social_media->insert($socialMedia);

                }
            }
            }
            
           $message = $request->name." ". __('webCaption.alert_updated_successfully.title');
        }                 
        else{
            $salesData['created_at'] =  \Carbon\Carbon::now()->toDateTimeString();
            $salesData['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString();
            //Insert Permission Code
            $companyUserModel->permissions()->attach($request->permissions);
            //Insert Data in the Company Sales Team Table
            $company_sales_team_insert_id = $company_sales_team->insertGetId($salesData);

            $socialMedia = array();
             if(is_array($request->social_media) && count($request->social_media)>0 && !empty($request->social_media)){
                foreach($request->social_media as $key=>$value){
                    $socialMedia['company_user_id'] = $companyUserModel->id;
                    $socialMedia['company_sales_team_id'] = $company_sales_team_insert_id;
                    $socialMedia['social_media_id'] = $value;
                    $socialMedia['value'] = $request->social_value[$key];
                    $socialMedia['created_at'] =  \Carbon\Carbon::now()->toDateTimeString();
                    $socialMedia['updated_at'] =  \Carbon\Carbon::now()->toDateTimeString(); 
                    //Insert Data in the Sales Team Social Media Table
                    $company_sales_team_social_media->insert($socialMedia);

                    $message =  $request->name." ". __('webCaption.alert_added_successfully.title');
                }
            }
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

        $status = json_decode(json_encode($this->status));
        return view('dash.content.users.create',['permissions' => $permissions ,'user' => $user ,'breadcrumbs' => $breadcrumbs ,'status' => $status, 'department' => $department, 'designation' => $designation, 'country' => $country, 'language' => $language, 'religion' => $religion, 'social_media' => $social_media, 'socialMedia' => $socialMedia]);
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
            CompanySalesTeamSocialMedia::where('company_sales_team_id', $company_sales_team_data->id)->delete();
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
