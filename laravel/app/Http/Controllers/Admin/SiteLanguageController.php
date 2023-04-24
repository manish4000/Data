<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteLanguage;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiteLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  protected $moduleName   =   'Site Languages';
     protected $baseUrl      =   '';
     protected $url;
     public $menuUrl = 'admin/site-languages';
 
 
     public function __construct(UrlGenerator $url) {
         $this->url = $url;
         $this->baseUrl =  $this->url->to('/admin/site-languages');
     }

    public function index(Request $request)
    {   


        if (!Auth::user()->can('main-navigation-masters-languages')) {
            abort(403);
        }
        if (Auth::user()->can('main-navigation-masters-languages-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [];
        }
        
        $pageConfigs = [
            'moduleName' => __('webCaption.menu_main_navigation_masters_site_languages.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
       

        $languages = SiteLanguage::select('*');

        if($request->has('search.keyword')) {
            $languages->keywordFilter($request->input('search.keyword')); 
        }

        if($request->has('search.status') && $request->input('search.status') != null  ) {
            $languages->statusFilter($request->input('search.status')); 
        }

        if($request->has('search.show_in_masters') && $request->input('search.show_in_masters') != null  ) {
            $languages->showMasterFilter($request->input('search.show_in_masters')); 
        }

        if($request->has('search.show_in_captions') && $request->input('search.show_in_captions') != null  ) {
            $languages->showCaptionFilter($request->input('search.show_in_captions')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $languages->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $languages = $languages->paginate($perPage);
       
        return view('content.admin.language.index', compact('languages','pageConfigs','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('main-navigation-masters-languages-add')) {
            abort(403);
        }

        $pageConfigs = [
            'moduleName' => __('webCaption.menu_main_navigation_masters_site_languages.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        return view('content.admin.language.create',['pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
                [
                    'language_en' => 'required|unique:site_languages,language_en,'.$request->id.',id,deleted_at,NULL', 
                    'language_text' => 'required|unique:site_languages,language_text,'.$request->id.',id,deleted_at,NULL', 
                    'status' => 'required',
                    'alias' =>'required|string|regex:/^\S*$/u',  
                ],
                [   
                    'language_en.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.title_english.title') ] ),
                    'language_en.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('language_en')] ),
                    'language_text.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.title_language.title') ] ),
                    'language_text.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('language_text')] ),
                    'status.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title') ] ),
                    'alias.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.alias.title') ] ),
                    'alias.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.alias.title') ] ),
                    'alias.regex' => __('webCaption.validation_space.title', ['field'=> __('webCaption.alias.title') ,"use" => "(_)" ] ),
                ]
                );

        if ($validator->fails()) {
        return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

       if($request->id){
            if (!Auth::user()->can('main-navigation-masters-languages-edit')) {
                abort(403);
            }
            $language =   SiteLanguage::find($request->id);
       }else{
            if (!Auth::user()->can('main-navigation-masters-languages-add')) {
                abort(403);
            }
            $language =   new SiteLanguage;
       }

        $language->language_en = $request->language_en;
        $language->language_text = $request->language_text;
        $language->status = $request->status;
        $language->default_lang = (($request->default_lang) != null)? 1 : 0;
        $language->alias = $request->alias;
        $language->show_in_captions = isset($request->show_in_captions)? $request->show_in_captions :0;
        $language->show_in_masters = isset($request->show_in_masters)?$request->show_in_masters:0;

        if(!empty($request->default_lang) &&  $request->default_lang == 1){
            (new SiteLanguage)->where('default_lang',1)->update(['default_lang' => 0]);
            $language->default_lang = 1;
        } else {
            $language->default_lang = 0;
        }
       
        if($language->save()){
            $message = (isset($request->id)) ? $request->language_en ." ".__('webCaption.alert_updated_successfully.title')  : $request->language_en." ".__('webCaption.alert_added_successfully.title')  ;
            return redirect()->route('site-languages.index')->with('success_message' ,$message );
            }else{
            return redirect()->route('site-languages.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
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
        if (!Auth::user()->can('main-navigation-masters-languages-edit')) {
            abort(403);
        }
        $pageConfigs = [
            'moduleName' => __('webCaption.menu_main_navigation_masters_site_languages.title'), 
            'baseUrl' => $this->baseUrl, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];

        $data = SiteLanguage::find($id);

        return view('content.admin.language.create', ['data' => $data,'pageConfigs'=> $pageConfigs,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl]);
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
        if (!Auth::user()->can('site-languages-language-edit')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'language_en' => 'required|unique:site_languages,language_en,'.$id.',id,deleted_at,NULL',
            'language_text' => 'required|unique:site_languages,language_text,'.$id.',id,deleted_at,NULL',
            'status' => 'required'
        ]);
  
        $language = SiteLanguage::find($id);
        $language->language_en = $request->language_en;
        $language->language_text = $request->language_text;
        $language->status = $request->status;
        $language->save();
      
        return redirect()->route('site-languages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {    
        if (!Auth::user()->can('main-navigation-masters-languages-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
        }   

        $siteLanguage = SiteLanguage::where('id', $request->id)->first();

        if($siteLanguage->default_lang != 1){
            if($siteLanguage->delete()){
                $result['status']     = true;
                $result['message']    =  __('webCaption.alert_deleted_successfully.title') ;
               return response()->json(['result' => $result]);
    
            }else{
                $result['status']     = false;
                $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
                return response()->json(['result' => $result]);
            }
        }else{

            $result['status']     = false;
            $result['message']    = __('webCaption.delete_default_language_text.title'); 
            return response()->json(['result' => $result]);
            
        }

           
    }


    public function deleteMultiple( Request $request){

        if (!Auth::user()->can('main-navigation-masters-languages-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }

        if(SiteLanguage::whereIn('id', $request->delete_ids)->delete()){

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
