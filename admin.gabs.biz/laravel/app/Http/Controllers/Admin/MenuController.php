<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Permission;
use Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        // if (!$user->can('list-menu')) {
        //     abort(403);
        // }

        $menus = Menu::select('id', 'parent_id', 'title')->where('parent_id', 0)->get();
        $data = [];
        foreach ( $menus as $value ) {
            $value['level'] = 1;
            $data[] = $value;

            if (count($value->child) > 0) {
                foreach($value->child as $child) {
                    $child['level'] = 2;
                    $data[] = $child;
                }
            }
        }

        // dd($data);

        // $menus = Menu::where('parent_id', 0)->get();
        $permissions = Permission::all();
        return view('admin.menu.index', compact('data', 'menus', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = Auth::user();
        // if (!$user->can('add-menu')) {
        //     abort(403);
        // }

        // dd($request->all());

        $validatedData = $request->validate([
                'title' => 'required',
            ]);

        $menu = new Menu;
        $menu->title = $request->title;
        $menu->uri = $request->uri;
        $menu->icon = $request->icon;
        $menu->parent_id = isset($request->parent_id) ? $request->parent_id : 0;
        $menu->save();
      
        return redirect()->route('menu.index');
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
        if (!$user->can('update-menu')) {
            abort(403);
        }

        $menu = Menu::find($id);
        $menuList = Menu::where('parent_id', 0)->get();

        return view('admin.menu.edit', compact('menu', 'menuList'));
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
        if (!$user->can('update-menu')) {
            abort(403);
        }

        $validatedData = $request->validate([
                'title' => 'required',
            ]);

        $menu = Menu::find($id);
        $menu->title = $request->title;
        $menu->uri = $request->uri;
        $menu->parent_id = isset($request->parent_id) ? $request->parent_id : 0;
        $menu->save();
      
        return redirect()->route('menu.index');
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
        if (!$user->can('soft-delete-menu')) {
            abort(403);
        }

        // dd($id);

        $role = Menu::find($id)->delete();
        return redirect()->route('menu.index');
    }

    public function updateMenuPosition(Request $request) {
        $id = $request->id;
        $parent_id = $request->parent;

        $menu = Menu::find($id);
        $menu->parent_id = $parent_id;
        $menu->save();

        return response("Updated successfully!");
    }
}
