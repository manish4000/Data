<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteLanguage;
use App\Models\WebCaption;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class WebCaptionController extends Controller
{   
        
    // protected $moduleName   =   'Web Caption';
    protected $baseUrl      =   '';
    protected $url;
    public $menuUrl = 'admin/language-translation/web-caption';

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/language-translation/web-caption');
    }

    public function getLocalfile(){
        
        $languages =   SiteLanguage::select('id','alias')->where('status' ,'Active')->orderBy('default_lang','desc')->get()->pluck('alias', 'id')->toArray();
        $defalutLanguage_id = SiteLanguage::where('status','Active')->where('default_lang',1)->value('id');  
        $webcaptions = WebCaption::select('local_translations','local_slug' ,'title')->get();    
        $locale_array = [];
        foreach($languages as $id=>$lang){
            $locale_array[$lang] = [];
            $path = resource_path().'/lang/'.$lang;

            if(!File::exists($path)) {
             File::makeDirectory($path,0755);
            }
        }

        foreach($webcaptions as $webcaption) {

            $locale_translations = $webcaption->local_translations;
       

            foreach($languages as  $id=>$lang){
             
                if(isset($locale_translations[$id])) {
                    $locale_array[$lang][$webcaption->local_slug]['title'] = ($locale_translations[$id]['title'] == null) ? (isset($locale_translations[$defalutLanguage_id]['title'])? $locale_translations[$defalutLanguage_id]['title']: $webcaption['title'] )  : $locale_translations[$id]['title'] ;
                    $locale_array[$lang][$webcaption->local_slug]['caption'] = ($locale_translations[$id]['caption'] == null) ? '' : $locale_translations[$id]['caption'] ;
                }else{  
                      $locale_array[$lang][$webcaption->local_slug] =  ['title' => (isset($locale_translations[$defalutLanguage_id]['title'])? $locale_translations[$defalutLanguage_id]['title']: $webcaption['title'] ) ,'caption' => (isset($locale_translations[$defalutLanguage_id]['title'])? $locale_translations[$defalutLanguage_id]['title']: $webcaption['title'] )];
                }                
            }
        }

        $file_path = resource_path().'/lang/';

        foreach($locale_array as $lang => $locale){
        
            $fileStorePath =  $file_path.$lang.'/webCaption.php';

            $data = "<?php  \n return\n json_decode('".json_encode($locale) ."', true);?>";

            File::put($fileStorePath,$data);

        }

    }

    public function index(Request $request){

        if (!Auth::user()->can('main-navigation-masters-language-translation-caption')) {
            abort(403);
        }
        
        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => __('webCaption.web_caption.title'), 
        ];

        if (Auth::user()->can('main-navigation-masters-language-translation-caption-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/add',
                'name' => __('webCaption.add.title'),
            ];
        }else{
            $breadcrumbs[0] = [ ];
        }

        $data = WebCaption::select('title','id','local_slug','created_at','updated_at');

        // to be continue ......
        // if($request->has('search.pending_translation')){
        //    $data->pendingTranslation($request->input('search.pending_translation'));
        // }

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

        $data = $data->paginate($perPage);
        $local_translations = SiteLanguage::ActiveSiteLanguagesForCaption();

        return view('content.admin.webCaption.index',['pageConfigs' =>$pageConfigs, 'local_translations' => $local_translations ,'breadcrumbs' => $breadcrumbs ,'data' => $data]);
    }

    public function create(){

        if (!Auth::user()->can('main-navigation-masters-language-translation-caption-add')) {
            abort(403);
        }
        
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title'),
        ];
        $local_translations = SiteLanguage::ActiveSiteLanguagesForCaption();
        return view('content.admin.webCaption.create',['local_translations' => $local_translations,'breadcrumbs' => $breadcrumbs ,'menuUrl' => $this->menuUrl ]);
    }

    public function store(Request $request){

        if($request->id){
            if (!Auth::user()->can('main-navigation-masters-language-translation-caption-edit')) {
                abort(403);
            }
             $web_caption_model =   WebCaption::find($request->id);
        }else{
            if (!Auth::user()->can('main-navigation-masters-language-translation-caption-add')) {
                abort(403);
            }
             $web_caption_model =   new WebCaption;
        }

        $validator = Validator::make($request->all(),
                [
                    'title' => 'required|string', 
                    // 'title' => 'required|unique:web_captions,title,'.$request->id, 
                    'local_slug' => 'required|string|regex:/^\S*$/u|unique:web_captions,local_slug,'.$request->id, 
                ]  ,
                [   
                    'title.required'=> __('webCaption.validation_required.title', ['field'=> "title" ] ),
                    // 'title.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('title')] ),
                    'local_slug.required'=> __('webCaption.validation_required.title', ['field'=> "local_slug" ] ),
                    'local_slug.string' => __('webCaption.validation_string.title', ['field'=> "local_slug"] ),
                    'local_slug.regex' => __('webCaption.validation_space.title', ['field'=> "local_slug" ,"use" => "(_)" ] )
                ]                           
            );

            if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
            }

            $web_caption_model->title               =   $request->title;
            $web_caption_model->local_slug          =   $request->local_slug;
            
            $web_caption_model->local_translations   =   $request->local_translations;

            if($web_caption_model->save()){
                
            $message = (isset($request->id)) ? $request->title." " .__('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title');  
            return redirect()->route('language_translation.web_caption.index')->with('success_message' ,$message );
            }else{
            return redirect($this->baseUrl)->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
            }

    }

    public function edit($id){

        if (!Auth::user()->can('main-navigation-masters-language-translation-caption-edit')) {
            abort(403);
        }

        $data = WebCaption::where('id', $id)->first();
        $local_translations = SiteLanguage::ActiveSiteLanguagesForCaption();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];   
    
        return view('content.admin.webCaption.create', ['data' => $data,'breadcrumbs' => $breadcrumbs,'local_translations' => $local_translations ,'menuUrl' => $this->menuUrl]);

    }

    public function destroy(Request $request){

        if (!Auth::user()->can('main-navigation-masters-language-translation-caption-delete')) {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_delete_access.title'); 
            return response()->json(['result' => $result]);
            abort(403);
        }
        if(WebCaption::where('id', $request->id)->firstorfail()->delete()){
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
