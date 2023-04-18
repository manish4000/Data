<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\Company\CompanyContactPersonDetails;
use App\Models\Company\CompanyDocument;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyPlanModel;
use App\Models\Company\CompanyPlanPermissionModel;
use App\Models\Company\CompanyUserPermission;
use App\Models\CompanyGabsModel;
use App\Models\CompanyModel;
use App\Models\Dash\CompanyUsers;
use App\Models\Masters\Company\BusinessType;
use App\Models\Masters\Company\Company;
use App\Models\Masters\Country;
use App\Models\Masters\Vehicles\Type;
use App\Models\SiteLanguage;
use App\Models\StateModel;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{       
    protected $jsFileName   =   '';
    protected $moduleName   =   'Company';
    protected $basePath     =   '/content/admin/company/';
    protected $baseUrl      =   '';
    protected $url;
    protected $dataListCols;

    protected $status  =  [ 
        [ 'value' => 'Permitted', 'name'=> 'Permitted' ],
        [ 'value' => 'Blocked', 'name'=> 'Blocked' ],
        [ 'value'=> 'Pending', 'name'=> 'Pending' ], 
        [ 'value'=> 'New Email Verified', 'name'=> 'New Email Verified' ],
        [ 'value'=> 'Activation Pending', 'name'=> 'Activation Pending' ],
        [ 'value'=> 'Documents Pending', 'name'=> 'Documents Pending' ],
        [ 'value'=> 'Email Verify Pending', 'name'=> 'Email Verify Pending' ]
    ];

    // $this->status = json_decode(json_encode($this->status));

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/company');
    }

    public function importDataFromJct(){
       
        ini_set('max_execution_time', 300);
        $old_company_users_data = DB::table('usertbl')->where('inserted','0')->take(70)->get();


       foreach($old_company_users_data as $key => $value){

        $city = DB::table('cities')->where('name','like','%'.$value->city.'%')->value('id');
        $state = DB::table('states')->where('name','like','%'.$value->state.'%')->value('id');
        $country = Country::where('name','like','%'.$value->country.'%')->value('id');

        $city_id = isset($city) ? $city : null ;

        $state_id = isset($state) ? $state : null ;
        $country_id =isset($country) ? $country : null;

        $telephone = (isset($value->phone) && ($value->phone != '') ) ? $value->phone : null ;
        $telephone =  trim($telephone," ");
        
        $telephone = (($telephone != null) && (strpos($telephone,'+')  > 0 ) ) ? preg_replace("-", '_', ltrim($telephone,"+"), 1) : null;

        $business_type_ids = (isset($value->business_type_ids) && ($value->business_type_ids != null) && ($value->business_type_ids != '')? explode(',',$value->business_type_ids) :'' );

        $business_type_ids =  (isset($business_type_ids) &&  $business_type_ids != ''  ) ? json_encode($business_type_ids) : null;

        $company_name = (isset($value->company) && ($value->company != '') && ($value->company != null) ) ? $value->company  :'text company';
        
        $shortName = (isset($value->shortName) && ($value->shortName != '') && ($value->shortName != null) ) ? $value->shortName  : null;
        $address = (isset($value->address) && ($value->address != '') && ($value->address != null) ) ? $value->address  : null;
        $postcode = (isset($value->zip) && ($value->zip != '') && ($value->zip != null) ) ? $value->zip  : null;
        $website = (isset($value->website) && ($value->website != '') && ($value->website != null) ) ? $value->website  : null;
        $logo = (isset($value->logo_name) && ($value->logo_name != '') && ($value->logo_name != null) ) ? $value->logo_name  : null;
        $business_type = (isset($value->business_type) && ($value->business_type != '') && ($value->business_type != null) ) ? $value->business_type  : null;
        $marketing_status = (isset($value->	marketing_status) && ($value->	marketing_status != '') && ($value->	marketing_status != null) ) ? $value->	marketing_status  : null;
        $created_at = (isset($value->dateCreated) && ($value->dateCreated != '') && ($value->dateCreated != null) ) ? $value->dateCreated  : null; 
        $updated_at = (isset($value->update_date) && ($value->update_date != '') && ($value->update_date != null) ) ? $value->update_date  : null; 
        
        $gabs_uuid = rand(111111,899999);

        $company_user_data = [
            'company_name' => $company_name, 
            'name' => $company_name, 
            'email_id_1' => $value->emailOne, 
            'gabs_uuid' => $gabs_uuid, 
            'email' => $value->emailOne, 
            'short_name' => $shortName ,
            'password' => Hash::make($value->password),
            'status' => ucwords($value->status),
            'address' => $address,
            'city_id' => $city_id,
            'state_id' => $state_id,
            'country_id' => $country_id,
            'postcode' =>  $postcode,
            'region_id' => null,
            'telephone' => $telephone,
            'skype_id'=> null,
            'website'=> $website,
            'logo'=> $logo,
            'business_type_id' => $business_type_ids,
            'business_type' => $business_type,
            'permit_no' => null,
            'admin_comment' => null,
            'facebook' => null,
            'instagram' => null,
            'youtube' => null,
            'twitter' => null,
            'linkedin' => null,
            'marketing_status' => $marketing_status,
            'terms_and_services' => '1',
            'created_at' => $created_at,
            'updated_at' =>  $updated_at,
            'deleted_at' => null,
            'plan_id' => '2'
            ];

            if( $inserted_id = CompanyGabsModel::insertGetId($company_user_data)){

                DB::table('usertbl')->where('userId',$value->userId)->update(['inserted' => '1']);
                
                $company_model = new CompanyModel;
 
                $company_model_data = [
                    'company_gabs_id' => $inserted_id,
                    'company_name' =>  $company_name,
                    'email' =>  $value->emailOne,
                    'gabs_uuid'=>      $gabs_uuid,
                    'status' =>        ucwords($value->status),
                    'city_id' =>       $city_id,
                    'state_id' =>      $state_id,
                    'country_id' =>    $country_id,
                    'skype_id' =>      null,
                    'website' =>       $website,
                    'address' =>       $address,
                    'telephone' =>     $telephone ,
                    'postcode' =>      $postcode,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ];

                $company_model->insert($company_model_data);



                $company_users_model =  new CompanyUsers;

                $company_user_permissions =   CompanyPlanPermissionModel::where('company_plan_id','2')->value('permissions');

                    $data = [
                        'name' => $company_name,
                        'email' => $value->emailOne,
                        'password' => Hash::make($value->password),
                        'company_id' => $inserted_id,
                        'user_type' => 1,
                        'status' => $value->status,
                        'created_at'=> $created_at,
                        'updated_at'=> $updated_at
                        ];
                        
                        $company_user_id =  $company_users_model->insertGetId($data);
                        $company_user_add_permission  = CompanyUsers::find($company_user_id);
                        $company_user_add_permission->permissions()->attach($company_user_permissions);
                        // $company_user_add_permission  = CompanyUsers::find($company_user->id);
                        // $company_user_add_permission->permissions()->attach($request->permissions);

       }


    }
}





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (!Auth::user()->can('main-navigation-company-list')) {
            abort(403);
        } 


        $data = CompanyGabsModel::select(['id','name','company_name','email' ,'status','updated_at','updated_by']);

        
        if(  !empty($request->input('search.keyword') ) ) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if( !empty($request->input('search.country'))) {
            $data->countryFilter($request->input('search.country')); 
        }
        if( !empty($request->input('search.status'))) {
            $data->statusFilter($request->input('search.status')); 
        }
        if( !empty($request->input('search.plan'))) {
            $data->planFilter($request->input('search.plan')); 
        }

        if( !empty($request->input('search.business_type'))) {
            $data->businessTypeFilter($request->input('search.business_type')); 
        }
        

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }



        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 

        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl.'/create',
            'name' => 'Add'
        ];

        $status = json_decode(json_encode($this->status));

        $country = Country::get(['id as value' ,'name']);
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        $data = $data->paginate($perPage);
        
        $plans = CompanyPlanModel::select('id as value','title as name')->get();
        $BusinessTypes = BusinessType::select('id as value','name')->whereNotNull('name')->get();
        
        return view('content.admin.company.list',['plans' => $plans,'BusinessTypes' => $BusinessTypes,'pageConfigs' => $pageConfigs,'status' => $status,'country' => $country ,'breadcrumbs' => $breadcrumbs,'data' =>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {


        if (!Auth::user()->can('main-navigation-company-add')) {
            abort(403);
        } 
        $pageConfigs = [
            'pageHeader'    => true, 
            'baseUrl'       => $this->baseUrl, 
            'moduleName'    => $this->moduleName, 
            ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'list'
            ];

       
        $country = Country::get(['id as value' ,'name']);

        //$cities = DB::select('SELECT  id as value ,name FROM cities');

        $BusinessTypes = BusinessType::select('id as value','name')->whereNotNull('name')->where('is_service', 'No')->get();

        $status = json_decode(json_encode($this->status));

        $permissions = CompanyMenuGroupMenu::where('parent_id', 0)->get();

        // $siteLang =  SiteLanguage::where('alias',app()->getLocale())->first();
        // $defaultLang = SiteLanguage::where('alias',app()->getLocale())->value('id');    
        //return self::select(DB:raw('sum("json_extract('json_details', '$.salary')") ('title_languages->'.$siteLang->id.'->title as name')

        $plans = CompanyPlanModel::select('id as value','title as name')->get();
    
        // $types = Type::Select('id as value','name','title_languages->'.$siteLang->id.'->title as language_name')->get();        
 

        // foreach($types as $key => $type){

        //     $types[$key]['value'] = $type['value'];
        //     $types[$key]['name'] =  ($type['language_name'] == null || $type['language_name'] == '' || $type['language_name'] == 'null' ) ?  $type['name'] : $type['language_name']  ;

        // }
        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get();

        return view("content.admin.company.new_create",[ 'country_phone_code' => $country_phone_code,'plans' => $plans,'pageConfigs' => $pageConfigs ,'permissions' => $permissions,'country' => $country ,'breadcrumbs' => $breadcrumbs, 'status' =>$status,'BusinessTypes' => $BusinessTypes ]);
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
            if (!Auth::user()->can('main-navigation-company-edit')) {
                abort(403);
            } 
            $company_gabs_model = CompanyGabsModel::find($request->id);
            $company_gabs_model->updated_by = Auth::user()->id; 
        }else{
            if (!Auth::user()->can('main-navigation-company-add')) {
                abort(403);
            } 
            $company_gabs_model = new CompanyGabsModel; 
            $company_gabs_model->created_by = Auth::user()->id; 
        } 
         
        $request->validate(
            [
            'company_name' => 'required|max:255|unique:companies_gabs,company_name,'.$request->id, 
            'gabs_uuid' => 'required||max:6|unique:companies_gabs,gabs_uuid,'.$request->id, 
            'email' => 'required|max:45|unique:companies_gabs,email,'.$request->id, 
            'password' => 'required|min:5',
            'status' => 'required|string',
            'address' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'state_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'postcode' => 'nullable|string|max:15',
            'region_id' => 'nullable|numeric',
            'telephone' => 'nullable|string|max:20',
            'country_code' => 'required_with:telephone',
            'skype_id'=> 'nullable|string|max:25',
            'website'=> 'nullable|string|max:20',
            'logo'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
            'document.*'=> 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:6120',
            'plan_id' => 'nullable|numeric',
            'business_type_id.*' => 'nullable|numeric',
            'association_member_id' => 'nullable|numeric',
            'permit_no' => "nullable|string|max:250",
            'admin_comment' => 'nullable|string|max:250',
            'contact_name.*' => 'nullable|string|max:100',
            'contact_email.*' => 'nullable|email|max:50',
            'contact_designation.*' => 'nullable|string|max:50',
            'contact_phone.*' => 'nullable|string|max:20',
            'facebook' => 'nullable|url|max:100',
            'instagram' => 'nullable|url|max:100',
            'youtube' => 'nullable|url|max:100',
            'twitter' => 'nullable|url|max:100',
            'linkedin' => 'nullable|url|max:100',
            'terms_and_services' =>'nullable|in:0,1'

            ],[
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.company_name.title') ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.company_name.title') ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),

                'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.gabs_uuid.title') ] ),
                'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.gabs_uuid.title') ,"max" => "6"] ),
                'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title') ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                'password.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.password.title') ] ),
                'password.min'=> __('webCaption.validation_min.title', ['field'=> __('webCaption.password.title') ,"min" => "5"] ),

                'status.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title') ] ),
                'status.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.status.title') ] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.address.title') ] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.city.title')] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.state.title')] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.postcode.title') ] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.postcode.title') ,"max" => "15"] ),

                'region_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.region.title')] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.telephone.title')] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.telephone.title') ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),

                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.skype.title')  ] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.skype.title')  ,"max" => "25"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.website.title') ] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.website.title')  ,"max" => "20"] ),

                'logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.logo.title') ] ),
                'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.logo.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
                'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.logo.title') ,"max" => "6120"] ),

                // 'document.*.image' => __('webCaption.validation_image.title', ['field'=> "Document"] ),
                'document.*.mimes'=> __('webCaption.validation_mimes.title', ['field'=>__('webCaption.document.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
                'document.*.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.document.title') ,"max" => "6120"] ),

                'plan_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.plan.title')] ),

                'business_type_id.*.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.business_type.title') ] ),

                'association_member_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.association_member.title')] ),

                'permit_no.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.permit_number.title') ] ),
                'permit_no.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.permit_number.title') , "max" => "250"] ),

                'admin_comment.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.admin_comment.title')] ),
                'admin_comment.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.admin_comment.title') ,"max" => "250"] ),

                'contact_phone.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
                'contact_email.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "50"] ),
                'contact_designation.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title') ,"max" => "50"] ),
                'contact_name.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ,"max" => "100"] ),

                'contact_phone.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title')] ),
                'contact_email.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title')] ),
                'contact_designation.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title')] ),
                'contact_name.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),


                'facebook.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.facebook.title')] ),
                'facebook.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.facebook.title') ,"max" => "100"] ),

                'instagram.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.instagram.title') ] ),
                'instagram.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.instagram.title') ,"max" => "100"] ),

                'youtube.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.youtube.title') ] ),
                'youtube.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.youtube.title') ,"max" => "100"] ),

                'twitter.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.twitter.title') ] ),
                'twitter.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.twitter.title') ,"max" => "100"] ),

                'linkedin.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.linkedin.title') ] ),
                'linkedin.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.linkedin.title') ,"max" => "100"] ),

                'terms_and_services' => __('webCaption.validation_max.title', ['field'=> __('webCaption.accept_terms_and_services.title')] )

            ]
        );

            if($request->has('business_type_id')) {
    
                if(is_array($request->business_type_id) && count($request->business_type_id) > 0){
                
                    $business_type_id   = json_encode($request->business_type_id);
                    $business_type = BusinessType::select('name')->where('name','!=',null)->whereIn('id',$request->business_type_id)->get()->toArray();

                    $business_type = (empty($business_type))? null: implode(',', array_column( $business_type,'name' ));
                    }    
            }  
                            

              $company_gabs_model->company_name = $request->company_name;  
              //old field
              $company_gabs_model->name = $request->company_name;  
              $company_gabs_model->short_name = $request->company_name; 
              $company_gabs_model->email_id_1 = $request->email;   
              //
              $company_gabs_model->password =  Hash::make($request->password);  
              $company_gabs_model->gabs_uuid = $request->gabs_uuid;  
              $company_gabs_model->email = $request->email;  
             
              $company_gabs_model->status = $request->status;  
              $company_gabs_model->address = $request->address;  
              $company_gabs_model->city_id = $request->city_id;  
              $company_gabs_model->state_id = $request->state_id;  
              $company_gabs_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
              $company_gabs_model->business_type =  (isset($business_type)) ? $business_type : null;  
              $company_gabs_model->country_id = $request->country_id;  
              $company_gabs_model->postcode = $request->postcode;  
              $company_gabs_model->region_id = $request->region_id;  
              $company_gabs_model->telephone = (isset($request->telephone))? $request->country_code."_".$request->telephone :null;  
              $company_gabs_model->skype_id = $request->skype_id;  
              $company_gabs_model->website = $request->website;  
              $company_gabs_model->plan_id = $request->plan_id;  
              $company_gabs_model->association_member_id = $request->association_member_id;  
              $company_gabs_model->permit_no = $request->permit_no;  
              $company_gabs_model->admin_comment = $request->admin_comment;  
              $company_gabs_model->facebook = $request->facebook;  
              $company_gabs_model->instagram = $request->instagram;  
              $company_gabs_model->youtube = $request->youtube;  
              $company_gabs_model->twitter = $request->twitter;  
              $company_gabs_model->linkedin = $request->linkedin;  
              $company_gabs_model->terms_and_services = (isset($request->terms_and_services))?$request->terms_and_services :'0';  
              $company_gabs_model->ip_address = $request->ip();  


              //Document folder path 
              
              $folder = $request->gabs_uuid;

              if($request->has('logo')){
                $logo = time().'.'.$request->logo->extension();  
                $request->logo->move(public_path('company_data').'/'.$folder.'/logo', $logo);
                $company_gabs_model->logo = $logo;
              }
           

              if($company_gabs_model->save()){

                if(!isset($request->id)){

                    //save data to companies
                    
                    $company_model = new CompanyModel;

                    $telephone = (isset($request->telephone))? $request->country_code."_".$request->telephone :null;  

                    $company_model_data = [
                        'company_gabs_id' => $company_gabs_model->id,
                        'company_name' =>  $request->company_name,
                        'email' =>  $request->email,
                        'gabs_uuid'=>      $request->gabs_uuid,
                        'status' =>        $request->status,
                        'city_id' =>       $request->city_id,
                        'state_id' =>      $request->state_id,
                        'country_id' =>    $request->country_id,
                        'skype_id' =>      $request->skype_id,
                        'website' =>       $request->website,
                        'address' =>       $request->address,
                        'telephone' =>     $telephone ,
                        'postcode' =>      $request->postcode,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ];

                    $company_model->insert($company_model_data);

                    //save data to company users

                    $company_user_permissions =   CompanyPlanPermissionModel::where('company_plan_id',$request->plan_id)->value('permissions');

                    $company_users_model =  new CompanyUsers;
                    $status = ($request->status == 'Permitted')?'Permitted' : 'Blocked';
                    $company_user_data = [
                        'name' => $request->company_name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'company_id' => $company_gabs_model->id,
                        'user_type' => 1,
                        'status' => $status,
                        'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                        ];
                        $company_user_id =  $company_users_model->insertGetId($company_user_data);

                        $company_user_add_permission  = CompanyUsers::find($company_user_id);
                        $company_user_add_permission->permissions()->attach($company_user_permissions);

                }
  

               // this is for insert data company_contact_person_details 

                // if(($request->contact_name[0] != '') || ($request->contact_name[0] != null)  ){

                    $loop_time = count($request->contact_name);

                    $company_contact_person_model =   new  CompanyContactPersonDetails();

                    for($i=0; $i < 2; $i++){

                        $conatct_data = [
                            'company_id' => $company_gabs_model->id,
                            'name' =>  isset($request->contact_name[$i]) ? $request->contact_name[$i] : null,
                            'email' => isset($request->contact_email[$i])? $request->contact_email[$i]: null,
                            'designation' => isset($request->designation[$i])? $request->designation[$i] : null,
                            'phone' => isset($request->contact_phone[$i])? $request->contact_phone[$i] : null,
                            'viber' => isset($request->contact_viber[$i]) ? 1 : 0,
                            'line' => isset($request->contact_line[$i]) ?  1: 0,
                            'whatsapp' => isset($request->contact_whatsapp[$i]) ? 1 : 0,
                        ];

                        $company_contact_person_model->insert($conatct_data);  

                        $conatct_data = [];
                    }
                // }

                //this is for upload multiple files  

                if($request->has('document')){

                    foreach($request->document as $key => $document){
                        
                        $doc = time().rand(1,9999).'_document.'.$document->extension();  
                        $document->move(public_path('company_data').'/'.$folder.'/document' , $doc);
                        $document_file[$key]['company_id'] = $company_gabs_model->id;
                        $document_file[$key]['name'] = $doc;
                        $document_file[$key]['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
                        $document_file[$key]['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
         
                    }

                    $company_document_model =   new CompanyDocument;
                    $company_document_model->insert($document_file);

                }


                    $message = (isset($request->id)) ? $request->name." ".__('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
                    return redirect($this->baseUrl)->with(['success_message' => $message ]);
               }
               else
               {
                    return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
               }
      
        
    }


    public function stateList(Request $request){

        $state_list = StateModel::where('country_id',$request->id)->get();

        return response()->json( [ 'states' => $state_list]);

    }


    public function cityList(Request $request){

        $cities_list = CityModel::where('state_id',$request->id)->get();
        return response()->json( [ 'cities' => $cities_list]);
    }

    // public function store(Request $request)
    // {   
        
    //     if($request->id){
    //         if (!Auth::user()->can('main-navigation-company-edit')) {
    //             abort(403);
    //         } 
    //         $company_gabs_model = Company::find($request->id);
    //     }else{
    //         if (!Auth::user()->can('main-navigation-company-add')) {
    //             abort(403);
    //         } 
    //         $company_gabs_model = new Company; 
    //     } 
         
    //     $validator = Validator::make($request->all(),
    //         [
    //         'name' => 'required|unique:companies,name,'.$request->id, 
    //         'email' => 'nullable|unique:companies,email,'.$request->id, 
    //         'phone' => 'numeric' ,
    //         'whatapp_no' => 'nullable|number' ,
    //         'country_id' => 'nullable|numeric' ,
    //         'register_on' => 'nullable|date' ,
    //         'ip_address' => 'nullable|string' ,
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return redirect()->back()->with('errors', $validator->errors() )->withInput();
    //     }else{


    //              if($request->has('business_type_id')) {
          
    //                     if(is_array($request->business_type_id) && count($request->business_type_id)>0){
                        
    //                             $business_type_id   = json_encode($request->business_type_id);
                            
    //                             $business_type = Helper::__getValueFromId('Company\BusinessType', $request->business_type_id); 
    //                         }    
    //             }  
            
    //         // if($request->has('country_id') && $request->country_id > 0){
    //         //     $country = Helper::__getDataValueFromDataId('Country', $request->country_id);   
    //         // }
        
                

    //           $company_gabs_model->name = $request->name;  
    //           $company_gabs_model->password =  Hash::make($request->password);  
    //         //   $company_gabs_model->password =  $request->password;  
    //           $company_gabs_model->short_name = $request->short_name;  
    //           $company_gabs_model->company_name = $request->company_name;  
    //           $company_gabs_model->designation = $request->designation;  
    //           $company_gabs_model->email = $request->email;  
    //           $company_gabs_model->phone = $request->phone;  
    //           $company_gabs_model->whatapp_no = $request->whatapp_no;  
    //           $company_gabs_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
    //           $company_gabs_model->business_type =  (isset($business_type)) ? $business_type : null;  
    //           $company_gabs_model->country_id = $request->country_id;  
    //           $company_gabs_model->status = $request->status;  
    //           $company_gabs_model->tax_id_no = $request->tax_id_no;  
    //           $company_gabs_model->register_on = $request->register_on;  
    //           $company_gabs_model->ip_address = $request->ip_address;  
    //           $company_gabs_model->marketing_status = $request->marketing_status;  
    //           $company_gabs_model->marketing_memo_history = $request->marketing_memo_history;  
    //           $company_gabs_model->operating_system = $request->operating_system;  
    //           $company_gabs_model->admin_comment = $request->admin_comment;  
    //           $company_gabs_model->address = $request->address;  

    //           $company_gabs_model->updated_by = Auth::user()->id;  

    //           if($company_gabs_model->save()){

    //             if(!isset($request->id)){
    //                 $company_users_model =  new CompanyUsers;
    //                 $status = ($request->status == 'Permitted')?'Permitted' : 'Blocked';                    $company_user_data = [
    //                     'name' => $request->name,
    //                     'email' => $request->email,
    //                     'password' => Hash::make($request->password),
    //                     'company_id' => $company_gabs_model->id,
    //                     'user_type' => 1,
    //                     'status' => $status,
    //                     'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
    //                     'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
    //                     ];
    //                     $company_user  =  $company_users_model->create($company_user_data);
    //                     $company_user_add_permission  = CompanyUsers::find($company_user->id);
    //                     $company_user_add_permission->permissions()->attach($request->permissions);

    //             }
    //                 $message = (isset($request->id)) ? $request->name." ".__('webCaption.alert_updated_successfully.title') : $request->name." ".__('webCaption.alert_added_successfully.title') ;
    //                 return redirect($this->baseUrl)->with(['success_message' => $message ]);
    //            }
    //            else
    //            {
    //                 return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
    //            }



    //     }
    // }

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
        if (!Auth::user()->can('main-navigation-company-edit')) {
            abort(403);
        } 
        $pageConfigs = [
            'pageHeader'    => true, 
            'baseUrl'       => $this->baseUrl, 
            'moduleName'    => $this->moduleName, 
        ];

        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'list'
        ];

        $country = Country::get(['id as value' ,'name']);

        

        $BusinessTypes = BusinessType::whereNotNull('name')->where('is_service', 'No')->get([ "id as value", "name"]);
        

        $status = json_decode(json_encode($this->status));

       
        $data = CompanyGabsModel::with(['contcatPersonDetails','documents'])->find($id);
     
        $telephone  = (isset($data->telephone) && ($data->telephone != '') && ($data->telephone != null) ) ? explode('_',$data->telephone) : null;
        $data->telephone = ($telephone != null) ? $telephone[1] : null;

 
        $company_tel_country_code = (isset($telephone[0]))? $telephone[0] :null;  

        
        $plans = CompanyPlanModel::select('id as value','title as name')->get();
        $data->business_type_id  = json_decode($data->business_type_id);

        $permissions = CompanyMenuGroupMenu::where('parent_id', 0)->get();
        
        // $types = Type::get(['id as value' ,'name']);  
       
        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        // dd($data->contcatPersonDetails);

        return view('content.admin.company.new_edit',['country_phone_code' => $country_phone_code,'plans' => $plans,'company_tel_country_code' => $company_tel_country_code ,'data' => $data,'permissions' =>$permissions ,'status' =>$status ,'country' => $country , 'BusinessTypes' => $BusinessTypes , 'pageConfigs' => $pageConfigs ,'breadcrumbs' =>$breadcrumbs ]);
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
        
        if (!Auth::user()->can('main-navigation-company-edit')) {
            abort(403);
        } 

        $request->validate(
            [
            'company_name' => 'required|max:255|unique:companies_gabs,company_name,'.$request->id, 
            'gabs_uuid' => 'required||max:6|unique:companies_gabs,gabs_uuid,'.$request->id, 
            'email' => 'required|max:45|unique:companies_gabs,email,'.$request->id, 
            'password' => 'nullable|min:5',
            'status' => 'required|string',
            'address' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'state_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'postcode' => 'nullable|string|max:15',
            'region_id' => 'nullable|numeric',
            'telephone' => 'nullable|string|max:20',
            'country_code' => 'required_with:telephone',
            'skype_id'=> 'nullable|string|max:25',
            'website'=> 'nullable|string|max:75',
            'logo'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
            'document.*'=> 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:6120',
            'plan_id' => 'nullable|numeric',
            'business_type_id.*' => 'nullable|numeric',
            'association_member_id' => 'nullable|numeric',
            'permit_no' => "nullable|string|max:250",
            'admin_comment' => 'nullable|string|max:250',
            'contact_name.*' => 'nullable|string|max:100',
            'contact_email.*' => 'nullable|email|max:50',
            'contact_designation.*' => 'nullable|string|max:50',
            'contact_phone.*' => 'nullable|string|max:20',
            'facebook' => 'nullable|url|max:100',
            'instagram' => 'nullable|url|max:100',
            'youtube' => 'nullable|url|max:100',
            'twitter' => 'nullable|url|max:100',
            'linkedin' => 'nullable|url|max:100',
            'terms_and_services' =>'nullable|in:0,1'

            ],
            // [
            //     'contact_phone.*.max' => 'phone number may not be greater than 20 characters.',
            //     'contact_email.*.max' => 'phone email may not be greater than 50 characters.',
            //     'contact_designation.*.max' => 'phone number may not be greater than 50 characters.',
            //     'contact_name.*.max' => 'phone number may not be greater than 100 characters.',
            // ]
            [
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> ('webCaption.company_name.title') ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> ('webCaption.company_name.title') ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),

                'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.gabs_uuid.title') ] ),
                'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.gabs_uuid.title') ,"max" => "6"] ),
                'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title') ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                // 'password.required'=> __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.min'=> __('webCaption.validation_min.title', ['field'=>  __('webCaption.password.title') ,"min" => "5"] ),

                'status.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.status.title')  ] ),
                'status.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.status.title') ] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=>  __('webCaption.address.title')] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.city.title')] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.state.title')] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.postcode.title') ] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.postcode.title')  ,"max" => "15"] ),

                'region_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.region.title')] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.telephone.title')] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.telephone.title') ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title')  ] ),
                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.skype.title') ] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.skype.title')  ,"max" => "25"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.website.title')] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.website.title') ,"max" => "75"] ),

                'logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.logo.title')] ),
                'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.logo.title'),"fileTypes" => "jpeg,png,jpg,gif"] ),
                'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.logo.title'),"max" => "6120"] ),

                // 'document.*.image' => __('webCaption.validation_image.title', ['field'=> "Document"] ),
                'document.*.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.document.title'),"fileTypes" => "jpeg,png,jpg,gif,pdf"] ),
                'document.*.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.document.title'),"max" => "6120"] ),

                'plan_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.plan.title')] ),

                'business_type_id.*.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.business_type.title')] ),

                'association_member_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=>  __('webCaption.association_member.title')] ),

                'permit_no.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.permit_number.title') ] ),
                'permit_no.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.permit_number.title')  ,"max" => "250"] ),

                'admin_comment.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.admin_comment.title')] ),
                'admin_comment.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.admin_comment.title') ,"max" => "250"] ),

                'contact_phone.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
                'contact_email.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "50"] ),
                'contact_designation.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title') ,"max" => "50"] ),
                'contact_name.*.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ,"max" => "100"] ),

                'contact_phone.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title')] ),
                'contact_email.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title')] ),
                'contact_designation.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title')] ),
                'contact_name.*.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),


                'facebook.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.facebook.title')] ),
                'facebook.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.facebook.title') ,"max" => "100"] ),

                'instagram.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.instagram.title')] ),
                'instagram.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.instagram.title') ,"max" => "100"] ),

                'youtube.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.youtube.title')] ),
                'youtube.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.youtube.title') ,"max" => "100"] ),

                'twitter.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.twitter.title')] ),
                'twitter.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.twitter.title') ,"max" => "100"] ),

                'linkedin.url' => __('webCaption.validation_max.title', ['field'=> __('webCaption.linkedin.title')] ),
                'linkedin.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.linkedin.title') ,"max" => "100"] ),

                'terms_and_services' => __('webCaption.validation_max.title', ['field'=> __('webCaption.accept_terms_and_services.title')] )

            ]
        );

        if($request->has('business_type_id')) {
    
            if(is_array($request->business_type_id) && count($request->business_type_id) > 0){
            
                    $business_type_id   = json_encode($request->business_type_id);
                    $business_type = BusinessType::select('name')->where('name','!=',null)->whereIn('id',$request->business_type_id)->get()->toArray();
                    $business_type = (empty($business_type))? null: implode(',', array_column( $business_type,'name' ));
                }    
        }

        
        $company_gabs_model = CompanyGabsModel::find($request->id);

        $old_logo_name = $company_gabs_model->logo;

        $company_gabs_model->updated_by = Auth::user()->id; 

        
        $company_gabs_model->company_name = $request->company_name;  
        //old field
        $company_gabs_model->name = $request->company_name;  
        $company_gabs_model->short_name = $request->company_name;  
        //

        if($request->has('password')){
            $company_gabs_model->password =  Hash::make($request->password);  
        }

        $company_gabs_model->gabs_uuid = $request->gabs_uuid;  
        $company_gabs_model->email = $request->email;  
        $company_gabs_model->status = $request->status;  
        $company_gabs_model->address = $request->address;  
        $company_gabs_model->city_id = $request->city_id;  
        $company_gabs_model->state_id = $request->state_id;  
        $company_gabs_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
        $company_gabs_model->business_type =  (isset($business_type)) ? $business_type : null;  
        $company_gabs_model->country_id = $request->country_id;  
        $company_gabs_model->postcode = $request->postcode;  
        $company_gabs_model->region_id = $request->region_id;  
        $company_gabs_model->telephone =  ($request->telephone)? $request->country_code."_".$request->telephone : null;   
        $company_gabs_model->skype_id = $request->skype_id;  
        $company_gabs_model->website = $request->website;  
        $company_gabs_model->plan_id = $request->plan_id;  
        $company_gabs_model->association_member_id = $request->association_member_id;  
        $company_gabs_model->permit_no = $request->permit_no;  
        $company_gabs_model->admin_comment = $request->admin_comment;  
        $company_gabs_model->facebook = $request->facebook;  
        $company_gabs_model->instagram = $request->instagram;  
        $company_gabs_model->youtube = $request->youtube;  
        $company_gabs_model->twitter = $request->twitter;  
        $company_gabs_model->linkedin = $request->linkedin;  
        $company_gabs_model->terms_and_services = (isset($request->terms_and_services))?$request->terms_and_services :'0';  
        $company_gabs_model->ip_address = $request->ip(); 

        if($request->has('logo')){
            $logo = time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('company_data').'/'.$request->gabs_uuid.'/logo', $logo);
            $company_gabs_model->logo = $logo;
        
            if(is_file(public_path('company_data').'/'.$request->gabs_uuid.'/logo/'.$old_logo_name )){

                unlink(public_path('company_data').'/'.$request->gabs_uuid.'/logo/'.$old_logo_name);
            }

        }

        
        if($company_gabs_model->save()){

            //this is for insert data company_contact_person_details 

            // if(($request->contact_name[0] != '') || ($request->contact_name[0] != null)  ){
                
                // $loop_time = count($request->contact_name);

                $company_contact_person_model =   new  CompanyContactPersonDetails;

                $company_contact_person_model->where('company_id',$id)->delete();

                for($i=0; $i < 2; $i++){

                    $conatct_data = [
                        'company_id' => $id,
                        'name' => isset($request->contact_name[$i]) ? $request->contact_name[$i] : null,
                        'email' => isset($request->contact_email[$i]) ? $request->contact_email[$i] : null,
                        'designation' => isset($request->contact_designation[$i]) ? $request->contact_designation[$i] : null,
                        'phone' => isset($request->contact_phone[$i]) ?  $request->contact_phone[$i]: null,
                        'viber' => isset($request->contact_viber[$i])? 1: 0,
                        'line' => isset($request->contact_line[$i])? 1 : 0,
                        'whatsapp' => isset($request->contact_whatsapp[$i]) ? 1 : 0,
                    ];

                    $company_contact_person_model->insert($conatct_data);  
                    $conatct_data = [];
                }
            // }
        
        //update the company user details 
        
        
        if(isset($id)){

            $company_users_model =  CompanyUsers::where('company_id',$id)->where('user_type',1)->first();
            
           // $status = ($request->status == 'Permitted') ? 'Permitted' : 'Blocked';               

            $company_user_permissions =   CompanyPlanPermissionModel::where('company_plan_id',$request->plan_id)->value('permissions');


            if($request->has('password')){

                $company_user_data = [
                    'name' => $request->company_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => $request->status,
                    'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                ];

            }else{
                
                $company_user_data = [
                 'name' => $request->company_name,
                 'email' => $request->email,
                 'status' => $request->status,
                 'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                 ];
            }


                $company_users_model->update($company_user_data);

                CompanyModel::where('company_gabs_id',$id)->update(['status' => $request->status]);
                
                $company_user_add_permission  = CompanyUsers::find($company_users_model->id);
                $company_user_add_permission->permissions()->sync($company_user_permissions);

        }


        //update the company documents  images
        
        
        if($request->has('document')){

            foreach($request->document as $key => $document){
                
                $doc = time().rand(1,9999).'_document.'.$document->extension();  
                $document->move(public_path('company_data').'/'.$request->gabs_uuid.'/document' , $doc);
                $document_file[$key]['company_id'] = $id;
                $document_file[$key]['name'] = $doc;

                $document_file[$key]['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
                $document_file[$key]['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
 
            }

            $company_document_model =   new CompanyDocument;

            $old_documents_data =  $company_document_model->where('company_id',$id)->get(['id','name']);

            if($old_documents_data != null){

                foreach($old_documents_data as $old_doc){
                        if(file_exists(public_path('company_data').'/'.$request->gabs_uuid.'/document/'.$old_doc->name )){
                            unlink(public_path('company_data').'/'.$request->gabs_uuid.'/document/'.$old_doc->name);
                        }
                }
            }    

            
            $company_document_model->where('company_id',$id)->delete(); 
            $company_document_model->insert($document_file);

        }




          $message =  $request->name." ".__('webCaption.alert_updated_successfully.title') ;
          return redirect($this->baseUrl)->with(['success_message' => $message ]);
        }else{
            return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        if (!Auth::user()->can('main-navigation-company-delete')) {
            abort(403);
        } 

        $company_gabs_model =  CompanyGabsModel::find($request->id);

        $logo_image = $company_gabs_model->logo;

            //delete logo 

            if(is_file(public_path('company_data').'/'.$company_gabs_model->gabs_uuid.'/logo/'.$logo_image )){

                unlink(public_path('company_data').'/'.$company_gabs_model->gabs_uuid.'/logo/'.$logo_image);
            }

            //delete the referance of documents 
            $company_documents_name =   CompanyDocument::where('company_id',$request->id)->get(['name'])->toArray();
            $company_documents_name = array_column($company_documents_name ,'name');
            if(count($company_documents_name) > 0 ){
                foreach($company_documents_name as $doc){

                    if(file_exists(public_path('company_data').'/'.$company_gabs_model->gabs_uuid.'/document/'.$doc )){
                        unlink(public_path('company_data').'/'.$company_gabs_model->gabs_uuid.'/document/'.$doc);
                    }

                }
            }

            CompanyDocument::where('company_id',$request->id)->delete();
            //delete the referance of and contact person details 
            CompanyContactPersonDetails::where('company_id',$request->id)->delete();

            //delete referance of companies 
            CompanyModel::where('company_gabs_id',$request->id)->delete();
            //delete the referance of company users 

            $company_users_ids =   CompanyUsers::where('company_id',$request->id)->get(['id'])->toArray();
            $company_users_ids = array_column($company_users_ids,'id');
            //delete related users
             CompanyUsers::whereIn('id' ,$company_users_ids )->delete();  
            //delete related users permissions 
            CompanyUserPermission::whereIn('company_user_id',$company_users_ids)->delete();

            if(CompanyGabsModel::where('id', $request->id)->delete()){

            $result['status']     = true;
            $result['message']    = 'Successfully deleted'; 
        
            return response()->json(['result' => $result]);

            }else{
                $result['status']     = false;
                $result['message']    = 'Somthing Went Wrong...'; 
                return response()->json(['result' => $result]);
            }
    }


    public function deleteMultiple(Request  $request)
    {

        if (!Auth::user()->can('main-navigation-company-delete')) {
            abort(403);
        } 

        $companies =  CompanyGabsModel::wherein('id',$request->delete_ids)->get();

        foreach($companies as $company ){

            $logo_image = $company->logo;

                if(is_file(public_path('company_data').'/'.$company->gabs_uuid.'/logo/'.$logo_image )){

                    unlink(public_path('company_data').'/'.$company->gabs_uuid.'/logo/'.$logo_image);
                }

                //delete the referance of documents 
                $company_documents_name =   CompanyDocument::where('company_id',$company->id)->get(['name'])->toArray();
                $company_documents_name = array_column($company_documents_name ,'name');

                if(count($company_documents_name) > 0 ){
                    foreach($company_documents_name as $doc){
    
                        if(file_exists(public_path('company_data').'/'.$company->gabs_uuid.'/document/'.$doc )){
                            unlink(public_path('company_data').'/'.$company->gabs_uuid.'/document/'.$doc);
                        }
    
                    }
                }
                
            CompanyDocument::where('company_id',$company->id)->delete();
            //delete the referance of and contact person details 
            CompanyContactPersonDetails::where('company_id',$company->id)->delete();

            //delete referance of companies 
            CompanyModel::where('company_gabs_id',$company->id)->delete();
            //delete the referance of company users 

            $company_users_ids =   CompanyUsers::where('company_id',$company->id)->get(['id'])->toArray();
            $company_users_ids = array_column($company_users_ids,'id');
            //delete related users
             CompanyUsers::whereIn('id' ,$company_users_ids )->delete();  
            //delete related users permissions 
            CompanyUserPermission::whereIn('company_user_id',$company_users_ids)->delete();   

        }

        

        if(CompanyGabsModel::whereIn('id',$request->delete_ids)->delete()){

            $result['status']     = true;
            $result['message']    = 'Successfully deleted'; 
        
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = 'Somthing Went Wrong...'; 
            return response()->json(['result' => $result]);
        }
    }
}
