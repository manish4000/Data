<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masters\SocialMedia;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use App\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl ='admin/masters/social-media';


    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/social-media');
    }

    public function index(Request $request)
    {    
        if (!Auth::user()->can('masters-social-media')) {
            abort(403);
        }

        $pageConfigs = [
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.menu_masters_social_media.title'), 
        ];

        if (Auth::user()->can('masters-social-media-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'), 
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $data = SocialMedia::select('*');

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

        return view('content.admin.masters.social_media.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data'=>$data,'perPage' => $perPage]);
    }


    //send id as value because dynamic select work with  id as value  name as name  

    public function add() {

        if (!Auth::user()->can('masters-social-media-add')) {
            abort(403);
        }
        
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];
        
        return view('content.admin.masters.social_media.create-form',['menuUrl' =>$this->menuUrl,'breadcrumbs' =>$breadcrumbs]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         
        $old_icon_name = '';

        if($request->id){
            if (!Auth::user()->can('masters-social-media-edit')) {
                abort(403);
            }
            $social_media_model =   SocialMedia::find($request->id);
        
            $old_icon_name = $social_media_model->icon; 
           
        }else{
            if (!Auth::user()->can('masters-social-media-add')) {
                abort(403);
            }
            $social_media_model =   new SocialMedia;
        }

        $validator = Validator::make($request->all(),
          [
            'url' => 'required|url|max:100',
            'icon'=> 'required_without:id|image|mimes:jpeg,png,jpg,gif|max:5000',
            'display' => 'required',
            'name' => 'required|unique:social_medias,name,'.$request->id.',id,deleted_at,NULL', 
          ]  ,
          [
            'url.required' => __('webCaption.validation_required.title', ['field' => __('webCaption.url.title')]),
            'url.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.url.title') ] ),
            'url.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.url.title') ,"max" => "100"] ),
            'icon.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.icon.title') ] ),
            'icon.required_without'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.icon.title') ] ),
            'icon.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.icon.title') ] ),
            'icon.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.icon.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'icon.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.icon.title') ,"max" => "5000"] ),
            'name.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.name.title')  ] ),
            'display.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.display.title')  ] ),
            'name.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('name')] ),
          ]);
    
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

                $social_media_model->name       =   $request->name;
                $social_media_model->url       =   $request->url;

                if($request->has('icon')){
                   
                    $icon = time().'.'.$request->icon->extension();  
                    $request->icon->move(public_path('social_media'), $icon);
                    $social_media_model->icon = $icon;

                    if(is_file(public_path('social_media').'/'.$old_icon_name )){
                        unlink(public_path('social_media').'/'.$old_icon_name);
                    }
                }

                $social_media_model->display    =   $request->display;

                if($social_media_model->save()){
                    $message = (isset($request->id)) ? $request->name." ". __('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect()->route('masters.social-media.index')->with('success_message' ,$message );
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
        if (!Auth::user()->can('masters-social-media-edit')) {
            abort(403);
        }
        $data = SocialMedia::select('id', 'name','url','icon','display')->where('id', $id)->first();
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   

        return view('content.admin.masters.social_media.create-form',['data' => $data,'breadcrumbs' =>$breadcrumbs ,'activeSiteLanguages' => $activeSiteLanguages ,'menuUrl' =>$this->menuUrl]);
   
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

        if (!Auth::user()->can('masters-social-media-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = SocialMedia::find($request->id);
        if(is_file(public_path('social_media').'/'.$data->icon )){
            unlink(public_path('social_media').'/'.$data->icon);
        }

        if(SocialMedia::where('id', $request->id)->firstorfail()->delete()){

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

        if (!Auth::user()->can('masters-social-media-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $data = SocialMedia::whereIn('id', $request->delete_ids)->get();
        
        foreach($data as $item){
            if(is_file(public_path('social_media').'/'.$item->icon )){
                unlink(public_path('social_media').'/'.$item->icon);
            }
        }
        
        if(SocialMedia::whereIn('id', $request->delete_ids)->delete()){
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

        
        if (!Auth::user()->can('masters-social-media-edit')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_update_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        $__data = SocialMedia::FindOrFail($request->id);

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
