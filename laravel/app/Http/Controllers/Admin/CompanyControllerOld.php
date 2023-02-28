<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Masters\Company\Company;
use App\Models\Masters\Company\SocialMedia;
use App\Models\ModulePackage;
use App\Models\DealerCurrency;

use App\Models\Masters\Country;

use App\Models\DealerPhoto;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Crypt;

use Auth;

class CompanyControllerOld extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $jsFileName   =   '';
    protected $moduleName   =   'Company';
    protected $basePath     =   '/content/admin/company/';
    protected $baseUrl      =   '';
    protected $url;
    protected $dataListCols;
    protected $table;

    public function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/company');

        $modelObj = new Company;
        $this->table = $modelObj->getTable();
    }

    public function index()
    {   
        $pageConfigs = [
            'pageHeader'    => true, 
            'baseUrl'       => $this->baseUrl, 
            'moduleName'    => $this->moduleName, 
            'jsFileName'    => $this->jsFileName,
            'dataListCols'  => $this->dataListCols,
            'isParentModal' => false
        ];

        $this->breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'Manage'
        ];

        return view($this->basePath.'list', [
            'pageConfigs'   =>  $pageConfigs,
            'breadcrumbs'   =>  $this->breadcrumbs,
            
        ]);
    }

    public function getJsonList(Request $request){
        $this->GabsToJctServiceObj = new \App\Services\paginationService();
        $this->GabsToJctServiceObj->setPaginationData($request);

        $data_query = Company::whereNotNull('company_name');
        // dd($request->columns);
        $this->searchServiceObj = new \App\Services\searchService($request->columns, $data_query, $this->table);
        if($request->has('search')) $this->searchServiceObj->search_data = $request->search;
        if($request->has('params')) $this->searchServiceObj->params = $request->params;
        if($request->has('filters')) $this->searchServiceObj->filters = $request->filters;    
        $this->searchServiceObj->setSearchConditions();
        $data_query = $this->searchServiceObj->data_query;

        $recordsFiltered = $data_query->count();        
        $records = $data_query->orderBy('company_name', 'ASC')->offset($this->GabsToJctServiceObj->offset)->limit($this->GabsToJctServiceObj->limit)->get();

        $recordsTotal = Companies::count();
        
        $data['recordsTotal']       =   $recordsTotal;
        $data['recordsFiltered']    =   $recordsFiltered;
        $data['data']               =   $records; 
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // $pageConfigs = [
        //     'pageHeader'    => true, 
        //     'baseUrl'       => $this->baseUrl, 
        //     'moduleName'    => $this->moduleName, 
        //     'jsFileName'    => $this->jsFileName,
        //     'dataListCols'  => $this->dataListCols,
        //     'isParentModal' => false
        // ];
        
        $password = Str::random(6);

        // $this->breadcrumbs[0] = [
        //     'link' => $this->baseUrl,
        //     'name' => 'Add New'
        // ];

        $status = [ 
            [ 'value' => 'Permitted', 'name'=> 'Permitted' ],
            [ 'value' => 'Blocked', 'name'=> 'Blocked' ],
            [ 'value'=> 'Pending', 'name'=> 'Pending' ], 
            [ 'value'=> 'New Email Verified', 'name'=> 'New Email Verified' ],
            [ 'value'=> 'Activation Pending', 'name'=> 'Activation Pending' ],
            [ 'value'=> 'Documents Pending', 'name'=> 'Documents Pending' ],
            [ 'value'=> 'Email Verify Pending', 'name'=> 'Email Verify Pending' ]
        ];
        $status = json_decode(json_encode($status));

        $membershipTypes = [ 
            [ 'value' => 'premium', 'name' => 'Premium' ],
            [ 'value' => 'gold', 'name' => 'Gold' ],
            [ 'value' => 'free', 'name' => 'Free' ]
        ];
        $membershipTypes = json_decode(json_encode($membershipTypes));

        $socialmedias   = SocialMedia::orderBy('name', 'ASC')->get();
        
        // ####    MODEL ACCESS PATTERN 2
        $modelClass = "\App\Models\Masters\Company\OwnerShipType";
        $modelObj = new $modelClass();
        $OwnerShipTypes = $modelObj::whereNotNull('name')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\Company\DealerType";
        $modelObj = new $modelClass();
        $DealerTypes = $modelObj::whereNotNull('name')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\Company\BusinessType";
        $modelObj = new $modelClass();
        $BusinessTypes = $modelObj::whereNotNull('name')->where('is_service', 'No')->get([ "id as value", "name"]);
        $services = $modelObj::whereNotNull('name')->where('is_service', '<>', 'No')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\\Language";
        $modelObj = new $modelClass();
        $Languages = $modelObj::whereNotNull('name')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\Company\PaymentTerm";
        $modelObj = new $modelClass();
        $payment_terms = $modelObj::whereNotNull('name')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\Company\DealIns";
        $modelObj = new $modelClass();
        $data_query = $modelObj::whereNotNull('name');
        $data_query->where(function($query) {
            $query->whereNull('parent_id')->orWhere('parent_id', '','0');
        });
        $DealIns = $data_query->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\Company\Organization";
        $modelObj = new $modelClass();
        $Organizations = $modelObj::whereNotNull('name')->get([ "id as value", "name"]);

        $modelClass = "\App\Models\Masters\\Country";
        $modelObj = new $modelClass();
        $abbrivation = $modelObj::orderBy('name', 'ASC')->get(['country_code', 'phone_code']);

        $abbrivationData = [];
        foreach ($abbrivation as $value) {
            $value = $value->country_code.' | '.$value->phone_code;
            $abbrivationData[] = [ 'value' => $value, 'name' => $value ];
        }
        $abbrivationData = json_encode($abbrivationData);

        return view($this->basePath.'create-new', [
            // 'pageConfigs'       =>  $pageConfigs,
            'password'          =>  $password,
            // 'breadcrumbs'       =>  $this->breadcrumbs,
            'OwnerShipTypes'    =>  $OwnerShipTypes,
            'DealerTypes'       =>  $DealerTypes,
            'BusinessTypes'     =>  $BusinessTypes,
            'Languages'         =>  $Languages,
            'payment_terms'     =>  $payment_terms,
            'DealIns'           =>  $DealIns,
            'Organizations'     =>  $Organizations,
            'blocked_fields'    =>  '',
            'abbrivation'       =>  json_decode($abbrivationData),
            'socialmedias'      =>  $socialmedias,
            'status'            =>  $status,
            'membershipTypes'   =>  $membershipTypes,
            'services'          =>  $services
        ]); 
        // return view($this->basePath.'create-new', compact('password', 'socialmedias'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {   
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'short_name'    => 'required|unique:companies|max:20',
        //         'email1'        => 'required|email|unique:companies|max:75',
        //     ],
        //     [
        //         'short_name.required'   =>  'Required Short Name',
        //         'short_name.unique'     =>  'Short Name already exists',
        //         'email1.required'       =>  'Required Email1',
        //         'email1.email'          =>  'Enter a valid Email-1',
        //         'email1.unique'         =>  'Email-1 already exists',
        //     ]
        // );
        
        // if($validator->fails())     return redirect('/company/create')->withErrors($validator)->withInput();

        
        
        
        // $mobile1_contact_options = '';
        // if($request->has('mobile1_contact_options')) 
        //     $mobile1_contact_options = Helper::__makeMeImplode($request->mobile1_contact_options, ', '); 

        // $mobile2_contact_options = '';
        // if($request->has('mobile2_contact_options'))  
        //     $mobile2_contact_options = Helper::__makeMeImplode($request->mobile2_contact_options, ', ');

        // $dealer_type_id     = '';

        // $languages_id       = '';

        // $payment_terms_id   = '';
        // $payment_terms      = '';

        // $organizations_id   = '';
        // $organizations      = '';
        
        // $ownership_type_id  = '';
        // $ownership_type     = '';
        
        // $deals_in_id        = '';
        // $deals_in           = '';
        
        // $business_type_id   = '';
        // $business_type      = '';

        // $logo_file          = '';
        // $profile_file       = '';

        // $city       = '';
        // $state      = '';
        // $country    = '';

        // if($request->has('city_id') && $request->city_id>0)
        //     $city = Helper::__getDataValueFromDataId('Cities', $request->city_id);
            
        // if($request->has('state_id') && $request->state_id>0)
        //     $state = Helper::__getDataValueFromDataId('States', $request->state_id);   
            
        // if($request->has('country_id') && $request->country_id>0)
        //     $country = Helper::__getDataValueFromDataId('Countries', $request->country_id);   
            
        // if($request->has('dealer_type_id')) {
        //     if(is_array($request->dealer_type_id) && count($request->dealer_type_id)>0){
        //         $dealer_type_id = Helper::__makeMeImplode($request->dealer_type_id, ', ');
        //         $dealer_types = Helper::__getValueFromId('DealerTypes', $request->dealer_type_id);
        //     }
        // }
        
        // if($request->has('languages_id')) {
        //     if(is_array($request->languages_id) && count($request->languages_id)>0){
        //         $languages_id   = Helper::__makeMeImplode($request->languages_id, ', ');
        //         $languages = Helper::__getValueFromId('Languages', $request->languages_id);
        //     }
        // }
        
        // if($request->has('payment_terms_id')) {
        //     if(is_array($request->payment_terms_id) && count($request->payment_terms_id)>0){
        //         $payment_terms_id   = Helper::__makeMeImplode($request->payment_terms_id, ', ');
        //         $payment_terms = Helper::__getValueFromId('PaymentTerms', $request->payment_terms_id);
        //     }
        // }

        // if($request->has('organizations_id')) {
        //     if(is_array($request->organizations_id) && count($request->organizations_id)>0){
        //         $organizations_id   = Helper::__makeMeImplode($request->organizations_id, ', ');
        //         $organizations = Helper::__getValueFromId('Organizations', $request->organizations_id);
        //     }
        // }
        
        // if($request->has('ownership_type_id')) {
        //     if($request->ownership_type_id>0){
        //         $ownership_type_id  = $request->ownership_type_id;
        //         $ownership_type = Helper::__getDataValueFromDataId('OwnerShipTypes', $request->ownership_type_id);   
        //     }
        // }
        
        // if($request->has('deals_in_id')) {
        //     if(is_array($request->deals_in_id) && count($request->deals_in_id)>0){
        //         $deals_in_id    = Helper::__makeMeImplode($request->deals_in_id, ', ');
        //         $deals_in = Helper::__getValueFromId('DealIns', $request->deals_in_id);
        //     }
        // }
        
        // if($request->has('business_type_id')) {
        //     if(is_array($request->business_type_id) && count($request->business_type_id)>0){
        //         $business_type_id   = Helper::__makeMeImplode($request->business_type_id, ', ');
        //         $business_type = Helper::__getValueFromId('BusinessTypes', $request->business_type_id); 
        //     }    
        // }
        
        // $this->pictureServiceObj = new \App\Services\pictureService();
        // if($request->has('logo_file')){
        //     $file_extention =   $request->logo_file->extension();
        //     $file_type      =   $request->logo_file->getMimeType();
        //     $logo_file = $this->pictureServiceObj->generateUniqueFileName().'.'.$file_extention;
        // } 
        // if($request->has('profile_file')){
        //     $file_extention =   $request->profile_file->extension();
        //     $file_type      =   $request->profile_file->getMimeType();
        //     $profile_file = $this->pictureServiceObj->generateUniqueFileName().'.'.$file_extention;
        // }  
       
        // $package_data = '';
        // $ModulePackagesData = ModulePackages::where('plan_type', $request->membership_type)->first();
        // if(isset($ModulePackagesData->package_data) && !empty($ModulePackagesData->package_data))
        //     $package_data = $ModulePackagesData->package_data;

        // $video_content = '';
        // if($request->has('video_content') && count($request->video_content)>0)
        //     $video_content = serialize($request->video_content);

        $dataToSave = [
            'name'                      => $request->company_name,
            'uuid'                      => \Str::uuid(),
            'dealer_type_id'            => $request->dealer_type_id,
            'short_name'                => $request->short_name,
            'membership_type_id'        => $request->membership_type_id,
            // 'email1'                    => $request->email1,
            // 'email2'                    => $request->email2,
            'address'                   => $request->address,
            'postcode'                  => $request->postcode,
            'city_id'                   => $request->city_id,
            'state_id'                  => $request->state_id,
            'country_id'                => $request->country_id,
            'language_id'               => $request->language_id,
            'payment_term_id'           => $request->payment_term_id,
            'organization_id'           => $request->organization_id,
            'website_prefix'            => $request->website_prefix,
            'website'                   => $request->website,
            'ownership_type_id'         => $request->ownership_type_id,
            'payment_term_id'           => $request->payment_term_id,
            'year_established'          => $request->year_established,
            'number_of_staffs'          => $request->number_of_staffs,
            'office_timing'             => $request->office_timing,
            'holidays'                  => $request->holidays,
            'deals_in_id'               => $request->deals_in_id,
            'business_type_id'          => $request->business_type_id,
            'dealer_permit_number'      => $request->dealer_permit_number,
            // 'facebook'                  => $request->facebook,
            // 'instagram'                 => $request->instagram,
            // 'linkedin'                  => $request->linkedin,
            // 'twitter'                   => $request->twitter,
            // 'youtube'                   => $request->youtube,
            // 'logo_file'                 => $logo_file,
            // 'profile_file'              => $profile_file,
            // 'package_data'              => $package_data,
            // 'video_content'             => $video_content
        ];

        $insert = Company::create($dataToSave);
        if(isset($insert->id) && $insert->id > 0){ 
            $companySocialProfile = new \App\Models\Masters\Company\CompanySocialProfile;
            $socialProfiles = $request->social_profiles;

            foreach ($socialProfiles as $key => $value) {
                $companySocialProfile->company_id = $insert->id;
                $companySocialProfile->social_platform = $key;
                $companySocialProfile->profile = $value;
                $companySocialProfile->save();
            }


            $user = User::create([
                'name'              =>  $request->short_name, 
                'email'             =>  $request->email1,
                'username'          =>  $request->username,
                'password'          =>  bcrypt($request->password),
                'user_type'         =>  'Company',
                'plan_type'         =>  $request->membership_type,
                'encrypt_string'    =>  Crypt::encryptString($request->password)
            ]);

            Companies::where('id', $insert->id)->update(['ref_id' => $user->id]);

            if(isset($request->country_id) && $request->country_id>0){
                $currencies_arr = ['USD', 'JPY'];
                $CountryCurr = Countries::where('id', '=', $request->country_id)->get(['currency'])->first();
                if(isset($CountryCurr->currency) && !empty($CountryCurr->currency)) $currencies_arr[] = $CountryCurr->currency;
                $currencies = Helper::__makeMeImplode($currencies_arr, ',');
                $datas = [            
                    'company_id'        => $insert->id,
                    'default_currency'  => 'USD',
                    'currencies'        => $currencies
                ];
                DealerCurrencies::create($datas);
            }

            $this->dirServiceObj = new \App\Services\directoryManagementService;
            $this->dirServiceObj->__setDirectoryStructureForDealersOneTime($insert->id);

            $this->pictureServiceObj = new \App\Services\pictureService();
            if($request->has('logo_file')){
                $image = $request->file('logo_file');
                $file_name = $logo_file;
                $this->pictureServiceObj->sourcePath    =   $image->path();
                $this->pictureServiceObj->folderName    =   'dealers/'.$insert->id.'/logo/';
                $this->pictureServiceObj->resizer_category = 'logo'; 
                $this->pictureServiceObj->resizePicture($file_name);
            }
            if($request->has('profile_file')){
                $image = $request->file('profile_file');
                $file_name = $profile_file;
                $this->pictureServiceObj->sourcePath    =   $image->path();
                $this->pictureServiceObj->folderName    =   'dealers/'.$insert->id.'/profile/';
                $this->pictureServiceObj->resizer_category = 'medium'; 
                $this->pictureServiceObj->resizePicture($file_name);
            }
            
            // if(!empty($logo_file))
            //     $request->logo_file->move(public_path('uploads/company/logo'), $logo_file);

            // if(!empty($profile_file))
            //     $request->profile_file->move(public_path('uploads/company/profile'), $profile_file);

            $result['status']     = true;
            $result['message']    = 'Successfully Added'; 
            $result['icon']       = 'success'; 
            return redirect('/company/create')->with($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $__data = Companies::FindOrFail($id);
        
        if(isset($__data->id))  $__data->load('staffs');
        if(isset($__data->video_content) && !empty($__data->video_content))  
            $__data->video_content = unserialize($__data->video_content);
    
        $dealerPhotos = DealerPhotos::where('company_id', '=', $__data->ref_id)->get(['file_name', 'file_category']);

        $this->breadcrumbs = [];
        return view('content/company/profile', [
            'data'          => $__data, 
            'dealerPhotos'  => $dealerPhotos,
            'breadcrumbs'   => $this->breadcrumbs
        ]);
    }

    public function list() {
        $modelClass = "\App\Models\Masters\\BusinessTypes";
        $modelObj = new $modelClass();
        $BusinessTypes = $modelObj::whereNotNull('name')->get();

        $modelClass = "\App\Models\Masters\\DealIns";
        $modelObj = new $modelClass();
        $data_query = $modelObj::whereNotNull('name');
        $data_query->where(function($query) {
            $query->whereNull('parent_id')->orWhere('parent_id', '','0');
        });
        $DealIns = $data_query->get();

        $modelClass = "\App\Models\Masters\\Languages";
        $modelObj = new $modelClass();
        $Languages = $modelObj::whereNotNull('name')->get();

        $pageConfigs = ['pageHeader' => false, 'baseUrl' => $this->baseUrl];
        return view($this->basePath.'list', [
            'pageConfigs'   =>  $pageConfigs,
            'BusinessTypes' =>  $BusinessTypes,
            'DealIns'       =>  $DealIns,
            'Languages'     =>  $Languages
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){   
        $data = [];
        if($id>0){
            $__data = Companies::FindOrFail($id);
            $password = '';
            $userObj = User::where('id', $__data->ref_id)->first();
            Crypt::decryptString($userObj->encrypt_string);
            if(isset($userObj->encrypt_string) && !empty($userObj->encrypt_string))
                $password = Crypt::decryptString($userObj->encrypt_string);

            if(isset($userObj->username) && !empty($userObj->username))
                $__data->username = $userObj->username;
            
            if(isset($__data->dealer_type_id) && !empty($__data->dealer_type_id))                   $__data->dealer_type_id             = Helper::__makeMeExplode($__data->dealer_type_id, ', ');
            if(isset($__data->languages_id) && !empty($__data->languages_id))                       $__data->languages_id               = Helper::__makeMeExplode($__data->languages_id, ', ');
            if(isset($__data->deals_in_id) && !empty($__data->deals_in_id))                         $__data->deals_in_id                = Helper::__makeMeExplode($__data->deals_in_id, ', ');
            if(isset($__data->business_type_id) && !empty($__data->business_type_id))               $__data->business_type_id           = Helper::__makeMeExplode($__data->business_type_id, ', ');
            if(isset($__data->organizations_id) && !empty($__data->organizations_id))               $__data->organizations_id           = Helper::__makeMeExplode($__data->organizations_id, ', ');
            if(isset($__data->mobile1_contact_options) && !empty($__data->mobile1_contact_options)) $__data->mobile1_contact_options    = Helper::__makeMeExplode($__data->mobile1_contact_options, ', ');
            if(isset($__data->mobile2_contact_options) && !empty($__data->mobile2_contact_options)) $__data->mobile2_contact_options    = Helper::__makeMeExplode($__data->mobile2_contact_options, ', ');
            if(isset($__data->video_content) && !empty($__data->video_content))                     $__data->video_content    = unserialize($__data->video_content);
            
            $pageConfigs = [
                'pageHeader'    => true, 
                'baseUrl'       => $this->baseUrl, 
                'moduleName'    => $this->moduleName, 
                'jsFileName'    => $this->jsFileName,
                'dataListCols'  => $this->dataListCols,
                'isParentModal' => false
            ];
            
            $this->breadcrumbs[0] = [
                'link' => $this->baseUrl,
                'name' => 'Add New'
            ];
            
            $socialmedias   = SocialMedias::orderBy('name', 'ASC')->get();

            $modelClass = "\App\Models\Masters\\OwnerShipTypes";
            $modelObj = new $modelClass();
            $OwnerShipTypes = $modelObj::whereNotNull('name')->get();
    
            $modelClass = "\App\Models\Masters\\DealerTypes";
            $modelObj = new $modelClass();
            $DealerTypes = $modelObj::whereNotNull('name')->get();
    
            $modelClass = "\App\Models\Masters\\BusinessTypes";
            $modelObj = new $modelClass();
            $BusinessTypes = $modelObj::whereNotNull('name')->get();
    
            $modelClass = "\App\Models\Masters\\Languages";
            $modelObj = new $modelClass();
            $Languages = $modelObj::whereNotNull('name')->get();
    
            $modelClass = "\App\Models\Masters\\DealIns";
            $modelObj = new $modelClass();
            $data_query = $modelObj::whereNotNull('name');
            $data_query->where(function($query) {
                $query->whereNull('parent_id')->orWhere('parent_id', '','0');
            });
            $DealIns = $data_query->get();
    
            $modelClass = "\App\Models\Masters\\Organizations";
            $modelObj = new $modelClass();
            $Organizations = $modelObj::whereNotNull('name')->get();

            $modelClass = "\App\Models\Masters\\Countries";
            $modelObj = new $modelClass();
            $abbrivation = $modelObj::orderBy('name', 'ASC')->get(['country_code', 'phone_code']);
            
            return view($this->basePath.'create', [
                'pageConfigs'       =>  $pageConfigs,
                'password'          =>  $password,
                'breadcrumbs'       =>  $this->breadcrumbs,
                'OwnerShipTypes'    =>  $OwnerShipTypes,
                'DealerTypes'       =>  $DealerTypes,
                'BusinessTypes'     =>  $BusinessTypes,
                'Languages'         =>  $Languages,
                'DealIns'           =>  $DealIns,
                'Organizations'     =>  $Organizations,
                'data'              =>  $__data,
                'blocked_fields'    =>  '',
                'abbrivation'       =>  $abbrivation,
                'socialmedias'      =>  $socialmedias
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $result = [];
        $validator = Validator::make(
            $request->all(),
            [
                'short_name' => 'required|unique:companies,short_name,'.$request->id,
                'email1' => 'required|email|unique:companies,email1,'.$request->id,
            ],
            [
                'short_name.required'   =>  'Required Short Name',
                'short_name.unique'     =>  'Short Name already exists',
                'email1.required'       =>  'Required Email1',
                'email1.email'          =>  'Enter a valid Email-1',
                'email1.unique'         =>  'Email-1 already exists',
            ]
        );
        
        if($validator->fails())     return redirect('/company/edit/'.$request->id)->withErrors($validator)->withInput(); 

        $__data = Companies::FindOrFail($request->id);
        
        $mobile1_contact_options = '';
        if($request->has('mobile1_contact_options')) 
            $mobile1_contact_options = Helper::__makeMeImplode($request->mobile1_contact_options, ', '); 

        $mobile2_contact_options = '';
        if($request->has('mobile2_contact_options'))  
            $mobile2_contact_options = Helper::__makeMeImplode($request->mobile2_contact_options, ', ');

        $dealer_type_id     = '';
        $dealer_types       = '';

        $languages_id       = '';
        $languages          = '';

        $organizations_id   = '';
        $organizations      = '';
        
        $ownership_type_id  = '';
        $ownership_type     = '';
        
        $deals_in_id        = '';
        $deals_in           = '';
        
        $business_type_id   = '';
        $business_type      = '';

        $logo_file          = '';
        $profile_file       = '';

        $city       = '';
        $state      = '';
        $country    = '';

        if($request->has('city_id') && $request->city_id>0)
            $city = Helper::__getDataValueFromDataId('Cities', $request->city_id);   
            
        if($request->has('state_id') && $request->state_id>0)
            $state = Helper::__getDataValueFromDataId('States', $request->state_id);   
            
        if($request->has('country_id') && $request->country_id>0)
            $country = Helper::__getDataValueFromDataId('Countries', $request->country_id);   
           
        if($request->has('dealer_type_id')) {
            if(is_array($request->dealer_type_id) && count($request->dealer_type_id)>0){
                $dealer_type_id = Helper::__makeMeImplode($request->dealer_type_id, ', ');
                $dealer_types = Helper::__getValueFromId('DealerTypes', $request->dealer_type_id);
            }
        }
        
        if($request->has('languages_id')) {
            if(is_array($request->languages_id) && count($request->languages_id)>0){
                $languages_id   = Helper::__makeMeImplode($request->languages_id, ', ');
                $languages = Helper::__getValueFromId('Languages', $request->languages_id);
            }
        }

        if($request->has('organizations_id')) {
            if(is_array($request->organizations_id) && count($request->organizations_id)>0){
                $organizations_id   = Helper::__makeMeImplode($request->organizations_id, ', ');
                $organizations = Helper::__getValueFromId('Organizations', $request->organizations_id);
            }
        }
        
        if($request->has('ownership_type_id')) {
            if($request->ownership_type_id>0){
                $ownership_type_id  = $request->ownership_type_id;
                $ownership_type = Helper::__getDataValueFromDataId('OwnerShipTypes', $request->ownership_type_id);   
            }
        }
        
        if($request->has('deals_in_id')) {
            if(is_array($request->deals_in_id) && count($request->deals_in_id)>0){
                $deals_in_id    = Helper::__makeMeImplode($request->deals_in_id, ', ');
                $deals_in = Helper::__getValueFromId('DealIns', $request->deals_in_id);
            }
        }
        
        if($request->has('business_type_id')) {
            if(is_array($request->business_type_id) && count($request->business_type_id)>0){
                $business_type_id   = Helper::__makeMeImplode($request->business_type_id, ', ');
                $business_type = Helper::__getValueFromId('BusinessTypes', $request->business_type_id); 
            }    
        }
        if($request->has('logo_file'))      $logo_file      = time().'.'.$request->logo_file->extension();
        if($request->has('profile_file'))   $profile_file   = time().'.'.$request->profile_file->extension();

        $package_data = '';
        $ModulePackagesData = ModulePackages::where('plan_type', $request->membership_type)->first();
        if(isset($ModulePackagesData->package_data) && !empty($ModulePackagesData->package_data))
            $package_data = $ModulePackagesData->package_data;

        $video_content = '';
        if($request->has('video_content') && count($request->video_content)>0)
            $video_content = serialize($request->video_content);
        
        $__data->company_name              = $request->company_name;
        $__data->dealer_type_id            = $dealer_type_id;
        $__data->dealer_types              = $dealer_types;
        $__data->short_name                = $request->short_name;
        $__data->membership_type           = $request->membership_type;
        //$__data->username                  = $request->username;
        $__data->email1                    = $request->email1;
        $__data->email2                    = $request->email2;
        $__data->address                   = $request->address;
        $__data->postcode                  = $request->postcode;
        $__data->city_id                   = $request->city_id;
        $__data->state_id                  = $request->state_id;
        $__data->country_id                = $request->country_id;
        $__data->city                      = $city;
        $__data->state                     = $state;
        $__data->country                   = $country;
        $__data->skype_id                  = $request->skype_id;
        $__data->mobile1                   = $request->mobile1;
        $__data->mobile2                   = $request->mobile2;
        $__data->mobile1_contact_options   = $mobile1_contact_options;
        $__data->mobile2_contact_options   = $mobile2_contact_options;
        $__data->mobile1_abbrivation       = $request->mobile1_abbrivation;
        $__data->mobile2_abbrivation       = $request->mobile2_abbrivation;
        $__data->languages_id              = $languages_id;
        $__data->languages                 = $languages;
        $__data->organizations_id          = $organizations_id;
        $__data->organizations             = $organizations;
        $__data->website_prefix            = $request->website_prefix;
        $__data->website                   = $request->website;
        $__data->ownership_type_id         = $ownership_type_id;
        $__data->ownership_type            = $ownership_type;
        $__data->payment_terms             = $request->payment_terms;
        $__data->year_established          = $request->year_established;
        $__data->number_of_staffs          = $request->number_of_staffs;
        $__data->office_timing             = $request->office_timing;
        $__data->holidays                  = $request->holidays;
        $__data->deals_in_id               = $deals_in_id;
        $__data->deals_in                  = $deals_in;
        $__data->business_type_id          = $business_type_id;
        $__data->business_type             = $business_type;
        $__data->dealer_permit_number      = $request->dealer_permit_number;
        $__data->slogan                    = $request->slogan;
        $__data->hp_welcome_text           = $request->hp_welcome_text;
        $__data->members_of_text           = $request->members_of_text;
        $__data->about_company_text        = $request->about_company_text;
        $__data->facebook                  = $request->facebook;
        $__data->instagram                 = $request->instagram;
        $__data->linkedin                  = $request->linkedin;
        $__data->twitter                   = $request->twitter;
        $__data->youtube                   = $request->youtube;
        $__data->package_data              = $package_data;
        $__data->video_content             = $video_content;        
        
        if(!empty($logo_file)){
            $request->logo_file->move(public_path('uploads/company/logo'), $logo_file);
            $__data->logo_file = $logo_file;
        }

        if(!empty($profile_file)){
            $request->profile_file->move(public_path('uploads/company/profile'), $profile_file);
            $__data->profile_file = $profile_file;
        }
        
        $__data->save();    //  UPDATE COMPANY RECORDS USING COMPANY ID

        User::where('id', $__data->ref_id)->update([
            'name'              =>  $request->short_name, 
            'email'             =>  $request->email1,
            'username'          =>  $request->username,
            'password'          =>  bcrypt($request->password),
            'encrypt_string'    =>  Crypt::encryptString($request->password)
        ]);        

        $result['status']     = true;
        $result['message']    = 'Successfully Updated'; 
        $result['icon']       = 'success'; 
        return redirect('/company/edit/'.$__data->id)->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Companies::where('id', $id)->firstorfail()->delete();
        $result = [
            'status' => true,
            'icon'  =>  'success',
            'title' =>  'Deleted!',
            'text' => 'Record has been deleted.'
        ];
        return response()->json($result, 200);
    }

    public function updateStatus(Request $request){
        $__data = Companies::FindOrFail($request->id);
        $__data->display = $request->display;
        $__data->save();  
        
        $result['status']     = true;
        $result['message']    = 'Successfully Updated'; 
        $result['icon']       = 'success'; 
        return response()->json($result);
    }

    public function checkShortNameExists(Request $request){
        if(isset($request->short_name) && !empty($request->short_name)){
            $query = Companies::where('short_name', $request->short_name); 
            $QueryReturn = $query->get();
            if($QueryReturn->count()>0){
                $result['status']     = false;
                $result['message']    = 'Short Name already exist'; 
                $result['icon']       = 'error'; 
            }
            else{
                $result['status']     = true;
                $result['message']    = 'Short Name available'; 
                $result['icon']       = 'success';     
            }            
            return response()->json($result);
        }
    }
}
