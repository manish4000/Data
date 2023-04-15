<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DepartmentPermission;
use App\Models\Masters\Country;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;
use PragmaRX\Google2FAQRCode\Google2FA;




class UserController extends Controller
{   

     //use RegistersUsers;
     use RegistersUsers {
        register as registration;
     }

    protected $baseUrl = '';
    protected $url;
    public $menuUrl ='admin/users';

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl = $this->url->to('admin/users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   


        if (!Auth::user()->can('settings-users')) {
            abort(403);
        }

        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        if (Auth::user()->can('settings-users-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [];
        }
      

        //$users = User::with(['roles'])->paginate(10);
        $users = User::select('*')->with(['roles']);

        if( $request->has('search.keyword')) {
            $users->keywordFilter($request->input('search.keyword')); 
        }

        if( $request->has('search.status') && $request->input('search.status') != null ) {
            $users->statusFilter($request->input('search.status')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $users->orderBy($request->order_by, $request->order);
        }
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $users = $users->paginate($perPage);
        // dd($users);  
        return view('content.admin.user.index', compact('users','pageConfigs','breadcrumbs'));
    }



    public function loginFromAdmin(Request $request){

        
        $id = Crypt::decrypt($request->id);
        $user  = User::where('id',$id)->first();
        
        if($user){
            auth()->logout();
            Session::flush();
            Auth::login($user);
            return redirect('/dashboard');
        }else{
            $message = __('webCaption.user_not_found.title'); 
            return redirect()->back()->with('error_message' ,$message );
        }
       
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('settings-users-add')) {
            abort(403);
        }
        // $user = Auth::user();
        $roles = Role::all();
      //  $permissions = Permission::where('parent_id', 0)->get();
           //change for testing  
        $permissions = Menu::with('menuGroup')->where('parent_id', 0)->get()->groupBy('menu_group_id');

        $departments =  Department::select('id as value','title as name')->get();
         
        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        // dd($country_phone_code);


        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.user.create', ['country_phone_code' => $country_phone_code, 'roles' => $roles ,'breadcrumbs' => $breadcrumbs ,'pageConfigs' => $pageConfigs, 'permissions' => $permissions ,'menuUrl' => $this->menuUrl ,'departments' => $departments]);
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {   
    //     // $user = Auth::user();
    //     if (!Auth::user()->can('users-edit')) {
    //         abort(403);
    //     }
    //     $user = User::with(['roles', 'permissions'])->find($id);
    //     $roles = Role::all();
    //     $permissions = Permission::where('parent_id', 0)->get();

    //     // $arrayData = [];
    //     // $permissionData = $this->permissionData($permissions, $arrayData);
    //     // dd($permissionData);

    //     return view('content.admin.user.edit', compact('user', 'roles', 'permissions'));
    // }

    public function edit($id)
    {   
        // $id = base64_decode($id);

        if (!Auth::user()->can('settings-users-edit')) {
            abort(403);
        }

        $user = User::with(['roles', 'permissions'])->find($id);
        $user->department_id  = json_decode($user->department_id);
        $phone                = (isset($user->phone) &&($user->phone != '') && ($user->phone != null) ) ? explode('_',$user->phone) : null;

        $user->phone = ($phone != null) ? $phone[1] : null;
        $country_code = (isset($phone[0]))? $phone[0] :'';
        $departments =  Department::select('id as value','title as name')->get();


        $roles = Role::all();
        //change for testing

        $permissions = Menu::with('menuGroup')->where('parent_id', 0)->get()->groupBy('menu_group_id');

        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        return view('content.admin.user.create', ['country_phone_code' => $country_phone_code ,'country_code' => $country_code,'pageConfigs' => $pageConfigs ,'departments' => $departments ,'breadcrumbs' =>$breadcrumbs ,'user' => $user ,'roles' => $roles,'permissions' => $permissions ,'menuUrl'=> $this->menuUrl]);

    }


    public function showPermission($id){

        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $user = User::with(['roles', 'permissions'])->find($id);
        $permissions = Menu::with('menuGroup')->where('parent_id', 0)->get()->groupBy('menu_group_id');

        return view('content.admin.user.permission',['breadcrumbs' =>$breadcrumbs,'user' => $user,'menuUrl' => $this->menuUrl,'pageConfigs' => $pageConfigs ,'permissions' => $permissions ]);
    }

    public function updatePermission(Request $request){

        $userModel =    User::find($request->id);
        
        if($userModel->permissions()->sync($request->permissions)){
            $message =  __('webCaption.alert_updated_successfully.title');
            return redirect()->route('users.index')->with('success_message' ,$message );
        }else{
            return redirect()->route('users.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        
        $request->validate([
            'name'     => 'required|max:100',
            'email'    => 'required|email|max:100|unique:users,email,'.$request->id,
            'phone' =>  'required|max:12',
            'country_code' =>  'required',
            'department_id'    => 'required|array',
            "department_id.*"  => "required|numeric|min:1",
            // 'username' =>  'required|unique:users,username,'.$request->id,
        ], [
            'name.required'=> __('webCaption.validation_required.title', ['field'=> "Name" ] ),
            'name.max'=> __('webCaption.validation_max.title', ['field'=> 'Name' ,'min' => "100"] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> "Email" ] ),
            'email.max' => __('webCaption.validation_max.title', ['field'=> 'Email' ,'max' => "100"] ),
            'phone.required'=> __('webCaption.validation_required.title', ['field'=> "Phone" ] ),
            'country_code.required'=> __('webCaption.validation_required.title', ['field'=> "Country Code" ] ),
            'phone.max'=> __('webCaption.validation_max.title', ['field'=> 'Phone' ,'max' => "12"] ),
            'department_id.required'=> __('webCaption.validation_required.title', ['field'=> "Department" ] ),
            'department_id.*.numeric'=> __('webCaption.validation_nemuric.title', ['field'=> "Department" ] ),
            // 'username.required'=> __('webCaption.validation_required.title', ['field'=> "Username" ] ),
            // 'username.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('username')] ),
        ]);



    
        if($request->id){
            if (!Auth::user()->can('settings-users-edit')) {
                abort(403);
            }

            $userModel =    User::find($request->id);

            $old_departments = json_decode( $userModel->department_id);
            $new_departments = $request->department_id;

    
            if(isset($request->password)){
                $request->validate([
                    'password' => 'required|confirmed|min:5',
                ],
                [
                        'password.required' => __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                        'password.min' => __('webCaption.validation_min.title', ['field'=> 'password' ,'min' => "5"] ),
                        'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> "Password" ] ),
                ]);
                $userModel->password = bcrypt($request->password);
            }

        }else{
            if (!Auth::user()->can('settings-users-add')) {
                abort(403);
            }

            $request->validate([
                'password' => 'required|confirmed|min:5',   
            ],
            [
                'password.required' => __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.min' => __('webCaption.validation_min.title', ['field'=> 'password' ,'min' => "5"] ),
                'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> "Password" ] ),
            ]);

            $userModel = new User();
            $userModel->password = bcrypt($request->password);
        }    
        
    

        if($request->id){
            if($old_departments != null){
                
                $differance_array_new_added =  array_diff($new_departments, $old_departments);
                $differance_array_new_remove =  array_diff( $old_departments, $new_departments);

                $common_department = array_intersect($new_departments,$old_departments);

                $user_old_permissions = UserPermission::where('user_id',$request->id)->get(['menu_id']);
                $user_old_permissions = (!empty($user_old_permissions) ) ? (array_column( json_decode(json_encode($user_old_permissions), true),'menu_id')):[];
  
                if(count($differance_array_new_remove) > 0){

                  $common_permission =    DepartmentPermission::whereIn('department_id',$common_department)->get(['menu_id']);
                  $common_permission = (array_column( json_decode(json_encode($common_permission), true),'menu_id'));

                  $permission_remove =  DepartmentPermission::whereIn('department_id',$differance_array_new_remove)->get(['menu_id']);
                  $permission_remove = (array_column( json_decode(json_encode($permission_remove), true),'menu_id'));



                  foreach($common_permission as $common_val){
                    $key = array_search($common_val, $permission_remove, true);
                    if ($key !== false) {
                        array_splice($permission_remove, $key, 1);
                    }
                }
  
                  foreach($permission_remove as $val){
                      $key = array_search($val, $user_old_permissions, true);
                      if ($key !== false) {
                          array_splice($user_old_permissions, $key, 1);
                      }
                  }
  
                }
  
                if(count($differance_array_new_added) > 0){
  
                  $permission_add =  DepartmentPermission::whereIn('department_id',$differance_array_new_added)->get(['menu_id']);
  
                  $permission_add = (array_column( json_decode(json_encode($permission_add), true),'menu_id'));
  
                   
                  $user_old_permissions = array_merge($user_old_permissions,$permission_add);
  
                }
             
                 $user_permission_to_sync =  (array_unique($user_old_permissions));
              }
        }


        $requestDepartments =  ($request->department_id == null || $request->department_id == '') ? [] : $request->department_id;
        
        $permissions =  DepartmentPermission::whereIn('department_id',$requestDepartments)->get(['menu_id']);

        $userPermissions = (!empty($permissions) ) ? (array_column( json_decode(json_encode($permissions), true),'menu_id')) : [];

        $userModel->email = $request->email;
        $userModel->name = $request->name;
        $userModel->phone = $request->country_code."_".$request->phone;
        $userModel->allow_2fa = isset($request->allow_2fa) ? '1' : '0';


     

        if($request->has('department_id')) {
            if(is_array($request->department_id) && count($request->department_id) > 0){
                 $department_id   = json_encode($request->department_id);
            }    
        } 

        $userModel->department_id =   (isset($department_id)) ? $department_id : null; 

        if ( $userModel->save()) {
            if($request->id){
                 
             //code for permission on time of update the user        

             if($old_departments == null){
                $userModel->permissions()->sync($userPermissions);
             }else{
                $userModel->permissions()->sync($user_permission_to_sync);
             }
             
                $userModel->roles()->sync($request->roles);  
               
                $message =  $request->name." ". __('webCaption.alert_updated_successfully.title');
            }else{
                $userModel->roles()->attach($request->roles);
                $userModel->permissions()->attach($userPermissions);
                $message =  $request->name." ". __('webCaption.alert_added_successfully.title');
            }
            return redirect()->route('users.index')->with('success_message' ,$message );
        }else{
            return redirect()->route('users.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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

    public function addTwoStapVerification(Request $request){

        $user =  User::find($request->id);

        $google2fa = app('pragmarx.google2fa');

        $google2fa_secret = $google2fa->generateSecretKey();

        $user->last_auth_code = $google2fa_secret;

        $user->save();   
        
        $twoFa = new Google2FA();
        $key = $twoFa->generateSecretKey();
        $qr_image = $twoFa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $google2fa_secret
        );

        return response()->json(['qr_image' => $qr_image ,'google2fa_secret' => $google2fa_secret ]);
        
    }


    public function verifyTwoStapVerification(Request $request){

        $validator = Validator::make( $request->all(),[
            'id' => 'required|numeric',
            'one_time_password' => 'required|numeric',
        ],
        [
                'id.required' => __('webCaption.validation_required.title', ['field'=> "Id" ] ),
                'one_time_password.required' => __('webCaption.validation_required.title', ['field'=> 'OTP'] ),
                'one_time_password.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "OTP"] ),

        ]);

        if ($validator->fails()) {
            $result['status']     = false;
            $result['message']    = $validator->errors()->all(); 
            return response()->json(['result' => $result]);
        }

        $user =  User::find($request->id);

        $otp =  $request->one_time_password;
    
        $twoFa = new Google2FA();

        if($twoFa->verifyKey($user->last_auth_code, $otp)){

            $user =  User::find($request->id);
            $user->google2fa_secret = $user->last_auth_code;
            $user->allow_2fa = '1';
            $user->last_auth_code = null;
            $user->device_description = $request->device_description;
            $user->save();

            $result['status']     = true;
            $result['message']    = "verify successfully"; 
           
        }else{
            $result['status']     = false;
            $result['message']    = "Enter Correct OTP To Verify "; 
           
        }

        return response()->json(['result' => $result]);
         
    }   


    public function updateverifyTwoStapVerification(Request $request){

        $user =  User::find($request->id);

        $otp =  $request->one_time_password;
    
        $twoFa = new Google2FA();

        if($twoFa->verifyKey($user->google2fa_secret, $otp)){

            $result['status']     = true;
            $result['message']    = "verify successfully"; 
           
        }else{
            $result['status']     = false;
            $result['message']    = "Enter Correct OTP To Verify "; 
           
        }

        return response()->json(['result' => $result]);
         
    }  

    public function deleteTwoStapVerification(Request $request){

        $user =  User::find($request->id);

        $user->google2fa_secret = null;
        $user->last_auth_code = null;
        $user->device_description = null;
        $user->allow_2fa = '0';

        if($user->save()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
            return redirect()->back()->with('success_message' ,$result['message'] );
           
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return redirect()->back()->with('error_message' ,$result['message'] );
           
        }

         
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
       
        $user = Auth::user();
        if (!$user->can('update-user')) {
            abort(403);
        }

      
        if (!Auth::user()->can('users-edit')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ],[
            'name.required'=> __('webCaption.validation_required.title', ['field'=> "Name" ] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> "Email"] ),
        ]);
  
        // $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($user) {
            $user->roles()->sync($request->roles);
            $user->permissions()->sync($request->permissions);
        }
        return redirect()->route('users.index')->with('success_message' ,$request->name .__('webCaption.alert_updated_successfully.title'));
    }


    public function updateStatus($id){

      
        
        // if (!Auth::user()->can('main-navigation-masters-vehicle-type-edit')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_update_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

    
        $data = User::FindOrFail($id);

        if(isset($data->status)){
            $status =  ($data->status == 1)? 0 : 1;
            $data->status = $status;
            $data->save();  
            $message    = __('webCaption.alert_updated_successfully.title'); 
            return redirect()->back()->with('success_message' ,$message );
        }else{

            $message    = __('webCaption.alert_somthing_wrong.title'); 
            return redirect()->back()->with('error_message' ,$message );
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $user = Auth::user();

        if (!$user->can('settings-users-delete')) {
            abort(403);
        }
        UserPermission::where('user_id',$request->id)->delete();
        if(User::where('id', $request->id)->firstorfail()->delete()){


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

        if (!Auth::user()->can('settings-users-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        UserPermission::whereIn('user_id',$request->delete_ids)->delete();
        
        if(User::whereIn('id', $request->delete_ids)->delete()){
        
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
            return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }

        
    }




    public function profile()
    {
        $user = Auth::user();
        return view('admin.auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $password = $request->password;

        if (empty($password)) {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id
            ],[
                'name.required'=> __('webCaption.validation_required.title', ['field'=> "Name" ] ),
                'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
                'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
                'email.email'=> __('webCaption.validation_email.title', ['field'=> $request->input('email') ] ),
            ]);
        }
        else {
            $validatedData = $request->validate([
                'name' => 'required',
                'password' => 'required|confirmed|min:5',
                'email' => 'required|email|unique:users,email,'.$user->id
            ],[
                'name.required'=> __('webCaption.validation_required.title', ['field'=> "Name" ] ),
                'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
                'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
                'email.email'=> __('webCaption.validation_email.title', ['field'=> $request->input('email') ] ),
                'password.required'=> __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> "Password" ] ),
                'password.min'=> __('webCaption.validation_min.title', ['field'=> "Password" ,"min" => "5" ] ),
            ]);
            $encryptPassword = bcrypt($validatedData['password']);
            $user->password = $encryptPassword;
        }
  
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
      
        return redirect()->route('admin.user.profile');
    }

    public function permissionData($permissions, $arrayData) {
        $permissionData = [];
        foreach ($permissions as $permission) {
            $permissionData['text'] = $permission->name;

            if (count($permission->child) > 0) {
                // $childrens = [];
                $permissionData['children'] = $this->permissionData($permission->child, $arrayData);
            }
            $arrayData[] = $permissionData;
        }

        return $arrayData;
    }
}
