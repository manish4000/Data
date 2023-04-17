<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDataTranslation;
use App\Models\SiteLanguage;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Cloner\Data;

use function GuzzleHttp\Promise\all;

class MasterDataTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $baseUrl      =   '';
     protected $url;
     public $menuUrl = 'admin/language-translation/master-data-translation';
  
     public function __construct(UrlGenerator $url) {
         $this->url = $url;
         $this->baseUrl =  $this->url->to('/admin/language-translation/master-data-translation');
     }


    public function index(Request $request)
    {           
        if (!Auth::user()->can('main-navigation-masters-language-translation-master')) {
            abort(403);
        }
        $pageConfigs = [
            'moduleName' => __('webCaption.menu_language_translation_master_data_translation.title'), 
        ];

        $data = MasterDataTranslation::select('value','id','language_data','db_models','created_at');

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);

        return view('content.admin.masterDataTranslation.index',compact('pageConfigs','data'));
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
        //
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
        if (!Auth::user()->can('main-navigation-masters-language-translation-master-edit')) {
            abort(403);
        }

        $data = MasterDataTranslation::where('id', $id)->first();
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => __('webCaption.list.title')
        ];  
        $activeSiteLanguages = SiteLanguage::ActiveSiteLanguagesForMaster();
        return view('content.admin.masterDataTranslation.edit',['data' => $data,'activeSiteLanguages' => $activeSiteLanguages,'breadcrumbs' =>  $breadcrumbs ,'menuUrl' => $this->menuUrl]);
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
        if (!Auth::user()->can('main-navigation-masters-language-translation-master-edit')) {
            abort(403);
        }

        $validator = Validator::make($request->all(),
            [
                'value' => 'required|unique:master_data_translations,value,'.$request->id
            ],
            [
                'value.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.value.title') ] ),
                'value.unique' => __('webCaption.validation_unique.title', ['field'=> $request->input('value')] )   
            ]
            );
            if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors() )->withInput();
        }

        $master_data_trans_modal =   MasterDataTranslation::find($id);

        if($master_data_trans_modal->update(['language_data' => $request->language_data])){
            return redirect()->route('language_translation.master_data_translation.index')->with('success_message' ,$request->value." " .__('webCaption.alert_updated_successfully.title') );
        }else{
            return redirect()->route('language_translation.master_data_translation.index')->with(['error_message' => __('webCaption.alert_somthing_wrong.title') ]);
        }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
