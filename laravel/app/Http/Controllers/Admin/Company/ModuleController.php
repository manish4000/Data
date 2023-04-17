<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyModule;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl = 'admin/company/module';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/company/module');
    }

    public function index(Request $request)
    {    
       
        if (!Auth::user()->can('main-navigation-company-module')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.module.title'), 
        ];
        if (Auth::user()->can('main-navigation-company-module-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }

        $data = CompanyModule::select('*');
        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        return view('content.admin.company.module.index', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('main-navigation-company-module-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('content.admin.company.module.create', ['breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
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
            if (!Auth::user()->can('main-navigation-company-module-edit')) {
                abort(403);
            }
            $company_module =   CompanyModule::find($request->id);
         }else{
            if (!Auth::user()->can('main-navigation-company-module-add')) {
                abort(403);
            }
             $company_module = new CompanyModule;
         }

        $request->validate(
            ['title' => 'required|unique:company_modules,title,'.$request->id.',id,deleted_at,NULL'],
            ['title.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.title.title')  ] ) ,
             'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] )  
            ]
        );

       
        $company_module->title = $request->title;
        if($company_module->save()){
            $message = (isset($request->id)) ? $request->title ." ". __('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('company.module.index')->with('success_message' ,$message );
        }else{
            return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::user()->can('main-navigation-company-module-edit')) {
            abort(403);
        }

       $data =  CompanyModule::find($id);
       $breadcrumbs[0] = [
        'link' => $this->baseUrl,
        'name' => __('webCaption.list.title')
         ]; 
       return view('content.admin.company.module.create', ['breadcrumbs' => $breadcrumbs,'data' =>$data ,'menuUrl' => $this->menuUrl]);
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
        // if (!Auth::user()->can('masters-vehicle-type-delete')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_delete_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

        if (!Auth::user()->can('main-navigation-company-module-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(CompanyModule::where('id', $request->id)->firstorfail()->delete()){
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


        if (!Auth::user()->can('main-navigation-company-module-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(CompanyModule::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }
}
