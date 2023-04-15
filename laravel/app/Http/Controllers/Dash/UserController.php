<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyUserPermission;
use App\Models\Dash\CompanyUsers;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

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

        return view('dash.content.users.create',['permissions' => $permissions,'breadcrumbs' => $breadcrumbs ,'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

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
        if (($givenPermission != null)  &&  !(array_intersect($givenPermission, $userPermission) === $givenPermission)) {
            abort(403);
        } 
             
       $companyId =  Auth::guard('dash')->user()->company_id;  
        

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:company_users,email,'.$request->id,
            'status'   => 'required',
            // 'username' =>  'required|unique:company_users,username,'.$request->id,
            'password' => 'nullable|confirmed|min:8',

        ],[
            'name.required' => __('webCaption.validation_required.title', ['field'=> "Name" ] ),
            'email.required' => __('webCaption.validation_required.title', ['field'=> "Email" ] ),
            'email.email'=> __('webCaption.validation_email.title', ['field'=> "Email" ] ),
            'email.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('email')] ),
            'status.required' => __('webCaption.validation_required.title', ['field'=> 'status'] ),
            'password.min' => __('webCaption.validation_min.title', ['field'=> 'password' ,'min' => "8"] ),
            'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> "Password" ] ),
          ]
        );

        if(!isset($request->id)){
            $request->validate([
                'password' => 'required|confirmed|min:8',   
            ],[
                'password.required' => __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.min' => __('webCaption.validation_min.title', ['field'=> 'password' ,'min' => "8"] ),
                'password.confirmed'=> __('webCaption.validation_confirmed.title', ['field'=> "Password" ] ),
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
        // $companyUserModel->username = $request->username;

        if ( $companyUserModel->save()) {
            if($request->id){
                // $companyUserModel->roles()->sync($request->roles);
                 $companyUserModel->permissions()->sync($request->permissions);
                $message =  $request->name." ". __('webCaption.alert_updated_successfully.title');
            }else{
                // $companyUserModel->roles()->attach($request->roles);
                 $companyUserModel->permissions()->attach($request->permissions);
                $message =  $request->name." ". __('webCaption.alert_added_successfully.title');
            }
            return redirect()->route('dashusers.index')->with('success_message' ,$message );

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

        $user = CompanyUsers::find($id);

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        // $permissions = CompanyMenuGroupMenu::where('parent_id', 0)->get();
        $permissions  = Auth::guard('dash')->user()->permissions->where('parent_id',0);

        $status = json_decode(json_encode($this->status));
        return view('dash.content.users.create',['permissions' => $permissions ,'user' => $user ,'breadcrumbs' => $breadcrumbs ,'status' => $status]);
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

        CompanyUserPermission::where('company_user_id' ,$request->id)->delete();
        
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

            CompanyUserPermission::whereIn('company_user_id' ,$request->delete_ids)->delete();
                   
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
