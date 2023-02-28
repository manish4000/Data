<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Routing\UrlGenerator;
use App\Models\Permission;
use Auth;

class RoleController extends Controller
{   
    protected $baseUrl      =   '';
    protected $url;

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/roles');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        // if (!$user->can('list-roles')) {
        //     abort(403);
        // }

        $pageConfigs = [
            'moduleName' => __('webCaption.roles.title'), 
            'baseUrl' => $this->baseUrl, 
        ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl.'/create',
            'name' => __('webCaption.add.title')
        ];

        $roles = Role::all();
        return view('content.admin.roles.index', compact('roles','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $user = Auth::user();
        if (!$user->can('add-role')) {
            abort(403);
        }

        $user = Auth::user();
        $permissions = Permission::where('parent_id', 0)->get();
        return view('content.admin.roles.create', compact('user', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('add-role')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:roles',
            'slug' => 'unique:roles',
        ]);
  
        $role = Role::create($validatedData);
        if ($role) {
            $role->permissions()->attach($request->permissions);
        }
      
        return redirect()->route('roles.index');
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
        $user = Auth::user();
        if (!$user->can('update-role')) {
            abort(403);
        }

        $role = Role::with('permissions')->find($id);
        $permissions = Permission::where('parent_id', 0)->get();

        return view('content.admin.roles.edit', compact('role', 'permissions'));
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
        if (!$user->can('update-role')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'slug' => 'unique:roles,slug,'.$id,
        ]);
  
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        if ($role) {
            $role->permissions()->sync($request->permissions);
        }
      
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->can('soft-delete-role')) {
            abort(403);
        }

        // dd($id);

        $role = Role::find($id)->delete();
        return redirect()->route('roles.index');
    }
}
