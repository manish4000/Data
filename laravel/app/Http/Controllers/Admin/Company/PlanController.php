<?php

namespace app\Http\Controllers\Admin\company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyPlanModel;
use App\Models\Company\CompanyPlanPermissionModel;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl = 'admin/company/plans';

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl = $this->url->to('admin/company/plans');
    } 


    public function index(Request $request)
    {   
        if (!Auth::user()->can('main-navigation-company-plans')) {
            abort(403);
        }

        $data =  CompanyPlanModel::select('*');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.plans.title'), 
        ];
        if (Auth::user()->can('main-navigation-company-plans-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [ ];
        }
        return view('content.admin.company.plans.index',compact('data','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (!Auth::user()->can('main-navigation-company-plans-add')) {
            abort(403);
        }
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title'), 
        ];
        return view('content.admin.company.plans.create',['breadcrumbs' => $breadcrumbs , 'menuUrl' => $this->menuUrl]);
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
            if (!Auth::user()->can('main-navigation-company-plans-edit')) {
                abort(403);
            }
            $companyPlanModel =  CompanyPlanModel::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-company-plans-add')) {
                abort(403);
            }
            $companyPlanModel = new CompanyPlanModel();
        }

        $request->validate(
            [
             'title' => 'required|unique:company_plans,title,'.$request->id.',id,deleted_at,NULL',
             'slug' => 'required|regex:/^\S*$/u|unique:company_plans,slug,'.$request->id.',id,deleted_at,NULL',
             'order_by' => 'nullable|numeric'  
            ],
            [

             'title.required' => __('webCaption.validation_required.title', ['field'=> "title" ] ) ,
             'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] )  ,
             'slug.required' => __('webCaption.validation_required.title', ['field'=> "slug" ] ) ,
             'slug.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('slug')] )  ,
             'slug.regex' => __('webCaption.validation_space.title', ['field'=> "slug" ,"use" => "(_)" ]  ),
             'order_by.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Order" ] ),
            ]
        );

        $companyPlanModel->title = $request->title;
        $companyPlanModel->slug = $request->slug;
        $companyPlanModel->order_by = (isset($request->order_by))?$request->order_by : 0;
        if($companyPlanModel->save()){
            $message = (isset($request->id)) ? $request->title ." ". __('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title') ;
            return redirect()->route('company.plans.index')->with('success_message' ,$message );
        }else{
            return redirect()->route('company.plans.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::user()->can('main-navigation-company-plans-edit')) {
            abort(403);
        }
        $data =  CompanyPlanModel::find($id);
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
         ];

        return view('content.admin.company.plans.create',['data' => $data,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('main-navigation-company-plans-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        CompanyPlanPermissionModel::where('company_plan_id',$request->id)->delete();

        if(CompanyPlanModel::where('id', $request->id)->firstorfail()->delete()){

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

        if (!Auth::user()->can('main-navigation-company-plans-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        CompanyPlanPermissionModel::whereIn('company_plan_id',$request->delete_ids)->delete();

        if(CompanyPlanModel::whereIn('id', $request->delete_ids)->delete()){
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
