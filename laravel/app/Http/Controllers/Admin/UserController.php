<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{   

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
        if($request->has('order_by') &&  $request->has('order') ){
            $users->orderBy($request->order_by, $request->order);
        }
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

        $users = $users->paginate($perPage);

        return view('content.admin.user.index', compact('users','pageConfigs','breadcrumbs'));
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
        $permissions = Menu::where('parent_id', 0)->get();

        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.user.create', [ 'roles' => $roles ,'breadcrumbs' => $breadcrumbs ,'pageConfigs' => $pageConfigs, 'permissions' => $permissions ,'menuUrl' => $this->menuUrl ]);
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

        if (!Auth::user()->can('settings-users-edit')) {
            abort(403);
        }

        $user = User::with(['roles', 'permissions'])->find($id);

        $roles = Role::all();
        //change for testing

        $permissions = Menu::where('parent_id', 0)->get();

        $pageConfigs = [
            'moduleName' => __('webCaption.users.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        return view('content.admin.user.create', ['pageConfigs' => $pageConfigs ,'breadcrumbs' =>$breadcrumbs ,'user' => $user ,'roles' => $roles,'permissions' => $permissions ,'menuUrl'=> $this->menuUrl]);
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
            if (!Auth::user()->can('settings-users-edit')) {
                abort(403);
            }

            $userModel =    User::find($request->id);
            if(isset($request->password)){
                $request->validate([
                    'password' => 'required|confirmed|min:5',
                ]);
                $userModel->password = bcrypt($request->password);
            }

        }else{
            if (!Auth::user()->can('settings-users-add')) {
                abort(403);
            }
            $userModel = new User();
            $userModel->password = bcrypt($request->password);
        }    
        
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$request->id,
            'username' =>  'required|unique:users,username,'.$request->id,
        ]);

        if(!isset($request->id)){
            $request->validate([
                'password' => 'required|confirmed|min:5',   
            ]);
        }

        

        // $validatedData['password'] = bcrypt($validatedData['password']);

        $userModel->email = $request->email;
        $userModel->name = $request->name;
        $userModel->username = $request->username;
       
        //$user = User::create($validatedData);
        if ( $userModel->save()) {
            if($request->id){
                $userModel->roles()->sync($request->roles);
                $userModel->permissions()->sync($request->permissions);
                $message =  $request->name." ". __('webCaption.alert_updated_successfully.title');
            }else{
                $userModel->roles()->attach($request->roles);
                $userModel->permissions()->attach($request->permissions);
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

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $user = Auth::user();
        // if (!$user->can('update-user')) {
        //     abort(403);
        // }
        
        if (!Auth::user()->can('users-edit')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
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
            ]);
        }
        else {
            $validatedData = $request->validate([
                'name' => 'required',
                'password' => 'required|confirmed|min:5',
                'email' => 'required|email|unique:users,email,'.$user->id
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
