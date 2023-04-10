<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\Company\CompanyContactPersonDetails;
use App\Models\Company\CompanyDocument;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyPlanModel;
use App\Models\Company\CompanyPlanPermissionModel;
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
       
       $old_company_users_data = DB::table('usertbl')->where('inserted','0')->take(80)->get();


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
        
        $company_user_data = [
            'company_name' => $company_name, 
            'name' => $company_name, 
            'email_id_1' => $value->emailOne, 
            'gabs_uuid' => rand(111111,899999), 
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

            if( $inserted_id = Company::insertGetId($company_user_data)){

                DB::table('usertbl')->where('userId',$value->userId)->update(['inserted' => '1']);
                
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
                        'updated_at'=> $updated_at,
                        'inserted' => '1'
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
        if (!Auth::user()->can('main-navigation-company')) {
            abort(403);
        } 

        $data = Company::select(['id','name','company_name','email' ,'status','updated_at','updated_by']);

        
        if(  !empty($request->input('search.keyword') ) ) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if( !empty($request->input('search.country'))) {
            $data->countryFilter($request->input('search.country')); 
        }
        if( !empty($request->input('search.status'))) {
            $data->statusFilter($request->input('search.status')); 
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
        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

        $data = $data->paginate($perPage);

        
        return view('content.admin.company.list',['pageConfigs' => $pageConfigs,'status' => $status,'country' => $country ,'breadcrumbs' => $breadcrumbs,'data' =>$data]);
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

        $siteLang =  SiteLanguage::where('alias',app()->getLocale())->first();
        $defaultLang = SiteLanguage::where('alias',app()->getLocale())->value('id');    
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
            $company_model = Company::find($request->id);
            $company_model->updated_by = Auth::user()->id; 
        }else{
            if (!Auth::user()->can('main-navigation-company-add')) {
                abort(403);
            } 
            $company_model = new Company; 
            $company_model->created_by = Auth::user()->id; 
        } 
         
        $request->validate(
            [
            'company_name' => 'required|max:255|unique:companies,company_name,'.$request->id, 
            'gabs_uuid' => 'required||max:6|unique:companies,gabs_uuid,'.$request->id, 
            'email' => 'required|max:45|unique:companies,email,'.$request->id, 
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
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> "Company Name" ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> "Company Name" ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),

                'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> "GABS Uuid" ] ),
                'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> "GABS Uuid" ,"max" => "6"] ),
                'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> "Email" ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                'password.required'=> __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.min'=> __('webCaption.validation_min.title', ['field'=> "Password" ,"min" => "5"] ),

                'status.required'=> __('webCaption.validation_required.title', ['field'=> "Status" ] ),
                'status.string'=> __('webCaption.validation_string.title', ['field'=> "Status"] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=> "Address"] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "City"] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "State"] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Country"] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> "Postcode"] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> "Postcode" ,"max" => "15"] ),

                'region_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Region"] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> "Telephone"] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> "Telephone" ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> "Country Code" ] ),

                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> "Skype"] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> "Skype" ,"max" => "25"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> "Website"] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> "Website" ,"max" => "20"] ),

                'logo.image'=> __('webCaption.validation_image.title', ['field'=> "Logo"] ),
                'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> "Logo","fileTypes" => "jpeg,png,jpg,gif"] ),
                'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> "Logo","max" => "6120"] ),

                // 'document.*.image' => __('webCaption.validation_image.title', ['field'=> "Document"] ),
                'document.*.mimes'=> __('webCaption.validation_mimes.title', ['field'=> "Document","fileTypes" => "jpeg,png,jpg,gif"] ),
                'document.*.max'=> __('webCaption.validation_max_file.title', ['field'=> "Document","max" => "6120"] ),

                'plan_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Plan"] ),

                'business_type_id.*.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "business Type"] ),

                'association_member_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Association Member Id"] ),

                'permit_no.string'=> __('webCaption.validation_string.title', ['field'=> "Permit No"] ),
                'permit_no.max'=> __('webCaption.validation_max.title', ['field'=> "Permit No" ,"max" => "250"] ),

                'admin_comment.string'=> __('webCaption.validation_string.title', ['field'=> "Admin Comment"] ),
                'admin_comment.max'=> __('webCaption.validation_max.title', ['field'=> "Admin Comment" ,"max" => "250"] ),

                'contact_phone.*.max' => __('webCaption.validation_max.title', ['field'=> "Phone" ,"max" => "20"] ),
                'contact_email.*.max' => __('webCaption.validation_max.title', ['field'=> "Email" ,"max" => "50"] ),
                'contact_designation.*.max' => __('webCaption.validation_max.title', ['field'=> "Designation" ,"max" => "50"] ),
                'contact_name.*.max' => __('webCaption.validation_max.title', ['field'=> "Name" ,"max" => "100"] ),

                'contact_phone.*.string' => __('webCaption.validation_max.title', ['field'=> "Phone"] ),
                'contact_email.*.string' => __('webCaption.validation_max.title', ['field'=> "Email"] ),
                'contact_designation.*.string' => __('webCaption.validation_max.title', ['field'=> "Designation"] ),
                'contact_name.*.string' => __('webCaption.validation_max.title', ['field'=> "Name" ] ),


                'facebook.url' => __('webCaption.validation_max.title', ['field'=> "Facebook"] ),
                'facebook.max'=> __('webCaption.validation_max.title', ['field'=> "Facebook" ,"max" => "100"] ),

                'instagram.url' => __('webCaption.validation_max.title', ['field'=> "Instagram"] ),
                'instagram.max'=> __('webCaption.validation_max.title', ['field'=> "Instagram" ,"max" => "100"] ),

                'youtube.url' => __('webCaption.validation_max.title', ['field'=> "Youtube"] ),
                'youtube.max'=> __('webCaption.validation_max.title', ['field'=> "Youtube" ,"max" => "100"] ),

                'twitter.url' => __('webCaption.validation_max.title', ['field'=> "Twitter"] ),
                'twitter.max'=> __('webCaption.validation_max.title', ['field'=> "Twitter" ,"max" => "100"] ),

                'linkedin.url' => __('webCaption.validation_max.title', ['field'=> "linkedin"] ),
                'linkedin.max'=> __('webCaption.validation_max.title', ['field'=> "linkedin" ,"max" => "100"] ),

                'terms_and_services' => __('webCaption.validation_max.title', ['field'=> "Terms And Services"] )

            ]
        );

            if($request->has('business_type_id')) {
    
                if(is_array($request->business_type_id) && count($request->business_type_id) > 0){
                
                    $business_type_id   = json_encode($request->business_type_id);
                    $business_type = BusinessType::select('name')->where('name','!=',null)->whereIn('id',$request->business_type_id)->get()->toArray();

                    $business_type = (empty($business_type))? null: implode(',', array_column( $business_type,'name' ));
                    }    
            }  
                            

              $company_model->company_name = $request->company_name;  
              //old field
              $company_model->name = $request->company_name;  
              $company_model->short_name = $request->company_name; 
              $company_model->email_id_1 = $request->email;   
              //
              $company_model->password =  Hash::make($request->password);  
              $company_model->gabs_uuid = $request->gabs_uuid;  
              $company_model->email = $request->email;  
             
              $company_model->status = $request->status;  
              $company_model->address = $request->address;  
              $company_model->city_id = $request->city_id;  
              $company_model->state_id = $request->state_id;  
              $company_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
              $company_model->business_type =  (isset($business_type)) ? $business_type : null;  
              $company_model->country_id = $request->country_id;  
              $company_model->postcode = $request->postcode;  
              $company_model->region_id = $request->region_id;  
              $company_model->telephone = $request->country_code."_".$request->telephone;  
              $company_model->skype_id = $request->skype_id;  
              $company_model->website = $request->website;  
              $company_model->plan_id = $request->plan_id;  
              $company_model->association_member_id = $request->association_member_id;  
              $company_model->permit_no = $request->permit_no;  
              $company_model->admin_comment = $request->admin_comment;  
              $company_model->facebook = $request->facebook;  
              $company_model->instagram = $request->instagram;  
              $company_model->youtube = $request->youtube;  
              $company_model->twitter = $request->twitter;  
              $company_model->linkedin = $request->linkedin;  
              $company_model->terms_and_services = (isset($request->terms_and_services))?$request->terms_and_services :'0';  
              $company_model->ip_address = $request->ip();  


              //Document folder path 
              
              $folder = $request->gabs_uuid;

              if($request->has('logo')){
                $logo = time().'.'.$request->logo->extension();  
                $request->logo->move(public_path('company_data').'/'.$folder.'/logo', $logo);
                $company_model->logo = $logo;
              }
           

              if($company_model->save()){

                if(!isset($request->id)){

                    $company_user_permissions =   CompanyPlanPermissionModel::where('company_plan_id',$request->plan_id)->value('permissions');

                    $company_users_model =  new CompanyUsers;
                    $status = ($request->status == 'Permitted')?'Permitted' : 'Blocked';
                    $company_user_data = [
                        'name' => $request->company_name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'company_id' => $company_model->id,
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
                            'company_id' => $company_model->id,
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
                        $document_file[$key]['company_id'] = $company_model->id;
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
    //         $company_model = Company::find($request->id);
    //     }else{
    //         if (!Auth::user()->can('main-navigation-company-add')) {
    //             abort(403);
    //         } 
    //         $company_model = new Company; 
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
        
                

    //           $company_model->name = $request->name;  
    //           $company_model->password =  Hash::make($request->password);  
    //         //   $company_model->password =  $request->password;  
    //           $company_model->short_name = $request->short_name;  
    //           $company_model->company_name = $request->company_name;  
    //           $company_model->designation = $request->designation;  
    //           $company_model->email = $request->email;  
    //           $company_model->phone = $request->phone;  
    //           $company_model->whatapp_no = $request->whatapp_no;  
    //           $company_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
    //           $company_model->business_type =  (isset($business_type)) ? $business_type : null;  
    //           $company_model->country_id = $request->country_id;  
    //           $company_model->status = $request->status;  
    //           $company_model->tax_id_no = $request->tax_id_no;  
    //           $company_model->register_on = $request->register_on;  
    //           $company_model->ip_address = $request->ip_address;  
    //           $company_model->marketing_status = $request->marketing_status;  
    //           $company_model->marketing_memo_history = $request->marketing_memo_history;  
    //           $company_model->operating_system = $request->operating_system;  
    //           $company_model->admin_comment = $request->admin_comment;  
    //           $company_model->address = $request->address;  

    //           $company_model->updated_by = Auth::user()->id;  

    //           if($company_model->save()){

    //             if(!isset($request->id)){
    //                 $company_users_model =  new CompanyUsers;
    //                 $status = ($request->status == 'Permitted')?'Permitted' : 'Blocked';                    $company_user_data = [
    //                     'name' => $request->name,
    //                     'email' => $request->email,
    //                     'password' => Hash::make($request->password),
    //                     'company_id' => $company_model->id,
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

       
        $data = Company::with(['contcatPersonDetails','documents'])->find($id);
     
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
            'company_name' => 'required|max:255|unique:companies,company_name,'.$request->id, 
            'gabs_uuid' => 'required||max:6|unique:companies,gabs_uuid,'.$request->id, 
            'email' => 'required|max:45|unique:companies,email,'.$request->id, 
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
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> "Company Name" ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> "Company Name" ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),

                'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> "GABS Uuid" ] ),
                'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> "GABS Uuid" ,"max" => "6"] ),
                'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> "Email" ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                // 'password.required'=> __('webCaption.validation_required.title', ['field'=> "Password" ] ),
                'password.min'=> __('webCaption.validation_min.title', ['field'=> "Password" ,"min" => "5"] ),

                'status.required'=> __('webCaption.validation_required.title', ['field'=> "Status" ] ),
                'status.string'=> __('webCaption.validation_string.title', ['field'=> "Status"] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=> "Address"] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "City"] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "State"] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Country"] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> "Postcode"] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> "Postcode" ,"max" => "15"] ),

                'region_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Region"] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> "Telephone"] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> "Telephone" ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> "Country Code" ] ),
                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> "Skype"] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> "Skype" ,"max" => "25"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> "Website"] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> "Website" ,"max" => "75"] ),

                'logo.image'=> __('webCaption.validation_image.title', ['field'=> "Logo"] ),
                'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> "Logo","fileTypes" => "jpeg,png,jpg,gif"] ),
                'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> "Logo","max" => "6120"] ),

                // 'document.*.image' => __('webCaption.validation_image.title', ['field'=> "Document"] ),
                'document.*.mimes'=> __('webCaption.validation_mimes.title', ['field'=> "Document","fileTypes" => "jpeg,png,jpg,gif,pdf"] ),
                'document.*.max'=> __('webCaption.validation_max_file.title', ['field'=> "Document","max" => "6120"] ),

                'plan_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Plan"] ),

                'business_type_id.*.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "business Type"] ),

                'association_member_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Association Member Id"] ),

                'permit_no.string'=> __('webCaption.validation_string.title', ['field'=> "Permit No"] ),
                'permit_no.max'=> __('webCaption.validation_max.title', ['field'=> "Permit No" ,"max" => "250"] ),

                'admin_comment.string'=> __('webCaption.validation_string.title', ['field'=> "Admin Comment"] ),
                'admin_comment.max'=> __('webCaption.validation_max.title', ['field'=> "Admin Comment" ,"max" => "250"] ),

                'contact_phone.*.max' => __('webCaption.validation_max.title', ['field'=> "Phone" ,"max" => "20"] ),
                'contact_email.*.max' => __('webCaption.validation_max.title', ['field'=> "Email" ,"max" => "50"] ),
                'contact_designation.*.max' => __('webCaption.validation_max.title', ['field'=> "Designation" ,"max" => "50"] ),
                'contact_name.*.max' => __('webCaption.validation_max.title', ['field'=> "Name" ,"max" => "100"] ),

                'contact_phone.*.string' => __('webCaption.validation_max.title', ['field'=> "Phone"] ),
                'contact_email.*.string' => __('webCaption.validation_max.title', ['field'=> "Email"] ),
                'contact_designation.*.string' => __('webCaption.validation_max.title', ['field'=> "Designation"] ),
                'contact_name.*.string' => __('webCaption.validation_max.title', ['field'=> "Name" ] ),


                'facebook.url' => __('webCaption.validation_max.title', ['field'=> "Facebook"] ),
                'facebook.max'=> __('webCaption.validation_max.title', ['field'=> "Facebook" ,"max" => "100"] ),

                'instagram.url' => __('webCaption.validation_max.title', ['field'=> "Instagram"] ),
                'instagram.max'=> __('webCaption.validation_max.title', ['field'=> "Instagram" ,"max" => "100"] ),

                'youtube.url' => __('webCaption.validation_max.title', ['field'=> "Youtube"] ),
                'youtube.max'=> __('webCaption.validation_max.title', ['field'=> "Youtube" ,"max" => "100"] ),

                'twitter.url' => __('webCaption.validation_max.title', ['field'=> "Twitter"] ),
                'twitter.max'=> __('webCaption.validation_max.title', ['field'=> "Twitter" ,"max" => "100"] ),

                'linkedin.url' => __('webCaption.validation_max.title', ['field'=> "linkedin"] ),
                'linkedin.max'=> __('webCaption.validation_max.title', ['field'=> "linkedin" ,"max" => "100"] ),

                'terms_and_services' => __('webCaption.validation_max.title', ['field'=> "Terms And Services"] )

            ]
        );

        if($request->has('business_type_id')) {
    
            if(is_array($request->business_type_id) && count($request->business_type_id) > 0){
            
                    $business_type_id   = json_encode($request->business_type_id);
                
                    $business_type = BusinessType::select('name')->where('name','!=',null)->whereIn('id',$request->business_type_id)->get()->toArray();

                    $business_type = (empty($business_type))? null: implode(',', array_column( $business_type,'name' ));
                }    
        }

        
        $company_model = Company::find($request->id);

        $old_logo_name = $company_model->logo;

        $company_model->updated_by = Auth::user()->id; 

        
        $company_model->company_name = $request->company_name;  
        //old field
        $company_model->name = $request->company_name;  
        $company_model->short_name = $request->company_name;  
        //

        if($request->has('password')){
            $company_model->password =  Hash::make($request->password);  
        }

        $company_model->gabs_uuid = $request->gabs_uuid;  
        $company_model->email = $request->email;  
        $company_model->status = $request->status;  
        $company_model->address = $request->address;  
        $company_model->city_id = $request->city_id;  
        $company_model->state_id = $request->state_id;  
        $company_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
        $company_model->business_type =  (isset($business_type)) ? $business_type : null;  
        $company_model->country_id = $request->country_id;  
        $company_model->postcode = $request->postcode;  
        $company_model->region_id = $request->region_id;  
        $company_model->telephone =  ($request->telephone)? $request->country_code."_".$request->telephone : null;   
        $company_model->skype_id = $request->skype_id;  
        $company_model->website = $request->website;  
        $company_model->plan_id = $request->plan_id;  
        $company_model->association_member_id = $request->association_member_id;  
        $company_model->permit_no = $request->permit_no;  
        $company_model->admin_comment = $request->admin_comment;  
        $company_model->facebook = $request->facebook;  
        $company_model->instagram = $request->instagram;  
        $company_model->youtube = $request->youtube;  
        $company_model->twitter = $request->twitter;  
        $company_model->linkedin = $request->linkedin;  
        $company_model->terms_and_services = (isset($request->terms_and_services))?$request->terms_and_services :'0';  
        $company_model->ip_address = $request->ip(); 

        if($request->has('logo')){
            $logo = time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('company_data').'/'.$request->gabs_uuid.'/logo', $logo);
            $company_model->logo = $logo;
        
            if(is_file(public_path('company_data').'/'.$request->gabs_uuid.'/logo/'.$old_logo_name )){

                unlink(public_path('company_data').'/'.$request->gabs_uuid.'/logo/'.$old_logo_name);
            }

        }

        
        if($company_model->save()){

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
            
            $status = ($request->status == 'Permitted') ? 'Permitted' : 'Blocked';               

            $company_user_permissions =   CompanyPlanPermissionModel::where('company_plan_id',$request->plan_id)->value('permissions');

            if($request->has('password')){

                $company_user_data = [
                    'name' => $request->company_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => $status,
                    'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                ];

            }else{
                
                $company_user_data = [
                 'name' => $request->company_name,
                 'email' => $request->email,
                 'status' => $status,
                 'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                 ];
            }


                $company_users_model->update($company_user_data);

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
        
        if(Company::where('id', $request->id)->firstorfail()->delete()){
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
