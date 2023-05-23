<?php

namespace App\Http\Controllers\Dash\Masters;

use App\Http\Controllers\Controller;
use App\Models\Dash\Masters\OverheadCharges;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class OverheadChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='masters/erp/overhead-charges';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('masters/erp/overhead-charges');
    }

    public function index(Request $request)
    {    
        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.masters_erp_overhead_charges.title'), 
        ];

        if (Auth::guard('dash')->user()->can('masters-erp-overhead-charges-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = OverheadCharges::select('*');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
            $data->displayStatusFilter($request->input('search.displayStatus')); 
        }   

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        return view('dash.content.masters.erp.overhead_charges.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function create() {

        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-add')) {
            abort(403);
        }

        $data = array();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        return view('dash.content.masters.erp.overhead_charges.create-form',['data' => $data ,'menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs ]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         
        if($request->id){
            if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-edit')) {
                abort(403);
            }
            $overhead_charges_model =  OverheadCharges::find($request->id);
        }else{
            if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-add')) {
                abort(403);
            }
            $overhead_charges_model =   new OverheadCharges;
        }

        $validator = Validator::make($request->all(),
          [
            'display' => 'required',
            'name' => 'required|unique:overhead_charges,name,'.$request->id.',id,deleted_at,NULL' 
          ]  ,
          [
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
            'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
            'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
          ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

                $overhead_charges_model->name       =   $request->name;
                $overhead_charges_model->display    =   $request->display;
                $overhead_charges_model->description =  $request->description;

                if($overhead_charges_modeloverhead_charges_modeloverhead_charges_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('dashmasters.erpinvoices.overhead-charges.index')->with('success_message' ,$message );
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
        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-edit')) {
            abort(403);
        }
        $data = OverheadCharges::select('id', 'name','title_languages', 'display', 'description')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        return view('dash.content.masters.erp.overhead_charges.create-form',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages, 'menuUrl' =>$this->menuUrl]);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {

        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(OverheadCharges::where('id', $request->id)->firstorfail()->delete()){
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

        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(OverheadCharges::whereIn('id', $request->delete_ids)->delete()){
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title') ;
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }

        
    }


    public function updateStatus(Request $request){
 
        if (!Auth::guard('dash')->user()->can('masters-erp-overhead-charges-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = OverheadCharges::FindOrFail($request->id);

        if(isset($__data->display)){
            $display =  ($__data->display == "Yes")? "No" : "Yes";
            // $__data->display = $display;
            $__data->update(['display' => $display]);  
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_updated_successfully.title'); 
        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 

        }

        return response()->json(['result' => $result]);
    }
}