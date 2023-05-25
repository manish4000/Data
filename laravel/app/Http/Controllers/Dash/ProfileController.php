<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\CompanyModel;
use App\Models\Dash\CompanyUsers;
use App\Models\Masters\Company\Association;
use App\Models\Masters\Company\BusinessType;
use App\Models\Masters\Company\MarketingStatus;
use App\Models\Masters\Country;
use App\Models\Masters\Vehicles\Make;
use App\Models\Region;
use App\Models\StateModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{   

    protected $moduleName   =   'Profile';
    protected $basePath     =   '';
    protected $baseUrl      =   '';
    protected $url;



    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/profile');
    }

    public function edit(){

       
        $user =  Auth::guard('dash')->user();

        $company_users =  CompanyUsers::where('company_id',$user->company_id)->where('user_type',1)->first();

        $data = CompanyModel::where('company_gabs_id',$company_users->company_id)->first();
        $country = Country::orderBy('name')->get(['id as value' ,'name']);

        $telephone  = (isset($data->telephone) && ($data->telephone != '') && ($data->telephone != null) ) ? explode('_',$data->telephone) : null;
        $data->telephone = ($telephone != null) ? $telephone[1] : null;
        $data->business_type_id  = json_decode($data->business_type_id);
        $data->association_member_id	  = json_decode($data->association_member_id	);
        $company_tel_country_code = (isset($telephone[0]))? $telephone[0] :null;  

        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        $business_types = BusinessType::orderBy('name')->select('id as value','name')->get();
        $association = Association::orderBy('name')->select('id as value','name')->where('parent_id' ,'0')->get();
        $marketing_status = MarketingStatus::orderBy('name')->select('id as value','name')->where('parent_id' ,'0')->get();
        $regions = Region::orderBy('name')->select('id as value','name')->where('parent_id' ,'0')->get();
        return view('dash.content.profile',['data'=> $data,'country_phone_code' => $country_phone_code,'regions' => $regions ,'association' => $association ,'marketing_status' => $marketing_status,'business_types'=> $business_types,'country' => $country ,'company_tel_country_code' => $company_tel_country_code]);

    }


    public function updateProfile(Request $request){

        $request->validate(
            [
            'company_name' => 'required|max:255|unique:dash.companies,company_name,'.$request->id.',company_gabs_id,deleted_at,NULL', 
            // 'gabs_uuid' => 'required||max:6|unique:companies_gabs,gabs_uuid,'.$request->id, 
             'email' => 'required|max:45|unique:dash.companies,email,'.$request->id. ',company_gabs_id,deleted_at,NULL', 
            'address' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'state_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'postcode' => 'nullable|string|max:15',
            'region_id' => 'nullable|numeric',
            'logo'=> 'nullable|image|mimes:jpg,png,jpeg,svg,gif,tiff|max:6120',
            'business_type_id.*' => 'nullable|numeric',
            'marketing_status' => 'nullable|numeric',
            'association_member_id.*' => 'nullable|numeric',
            'permit_no' => "nullable|string|max:250",
        
            'telephone' => 'nullable|string|max:20',
            'country_code' => 'required_with:telephone',
            'skype_id'=> 'nullable|string|max:50',
            'website'=> 'nullable|string|max:75',
            
            'contact_1_name' => 'nullable|string|max:100',
            'contact_1_email' => 'nullable|email|max:50',
            'contact_1_designation.*' => 'nullable|string|max:50',
            'contact_1_phone' => 'nullable|string|max:20',
            'deals_in.*' => 'nullable|numeric',

            'contact_2_name' => 'nullable|string|max:100',
            'contact_2_email' => 'nullable|email|max:50',
            'contact_2_designation.*' => 'nullable|string|max:50',
            'contact_2_phone' => 'nullable|string|max:20',

            'facebook' => 'nullable|url|max:100',
            'instagram' => 'nullable|url|max:100',
            'youtube' => 'nullable|url|max:100',
            'twitter' => 'nullable|url|max:100',
            'linkedin' => 'nullable|url|max:100',

            ],[
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.company_name.title') ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.company_name.title') ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),


                'logo.image'=> __('webCaption.validation_image.title', ['field'=> __('webCaption.logo.title')] ),
                'logo.mimes'=> __('webCaption.validation_mimes.title', ['field'=> __('webCaption.logo.title'),"fileTypes" => "jpg,png,jpeg,svg,gif,tiff"] ),
                'logo.max'=> __('webCaption.validation_max_file.title', ['field'=> __('webCaption.logo.title'),"max" => "6120"] ),

                'permit_no.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.permit_number.title') ] ),
                'permit_no.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.permit_number.title')  ,"max" => "250"] ),


                // 'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> "GABS Uuid" ] ),
                // 'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> "GABS Uuid" ,"max" => "6"] ),
                // 'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> __('webCaption.email.title') ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.address.title') ] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.city.title')] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.state.title') ] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.postcode.title')] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.postcode.title') ,"max" => "15"] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.telephone.title')] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.telephone.title') ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country_code.title') ] ),

                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.skype.title') ] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.skype.title') ,"max" => "50"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> __('webCaption.website.title')] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> __('webCaption.website.title') ,"max" => "20"] ),  

                'contact_1_phone.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
                'contact_1_email.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "50"] ),
                'contact_1_designation.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title') ,"max" => "50"] ),
                'contact_1_name.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ,"max" => "100"] ),

                'contact_2_phone.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "20"] ),
                'contact_2_email.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title') ,"max" => "50"] ),
                'contact_2_designation.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title') ,"max" => "50"] ),
                'contact_2_name.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ,"max" => "100"] ),

                'contact_1_phone.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title')] ),
                'contact_1_email.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title')] ),
                'contact_1_designation.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title')] ),
                'contact_1_name.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),

                'contact_2_phone.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title')] ),
                'contact_2_email.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.email.title')] ),
                'contact_2_designation.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.designation.title')] ),
                'contact_2_name.string' => __('webCaption.validation_max.title', ['field'=> __('webCaption.name.title') ] ),


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

            ]
        );


        $user =  Auth::guard('dash')->user();
      
        $company_users =  CompanyUsers::where('company_id',$user->company_id)->where('user_type',1)->first();

        $company_model =   CompanyModel::where('company_gabs_id',$company_users->company_id)->first();

        $telephone = (isset($request->telephone)) ? $request->country_code."_".$request->telephone :null;

        if($request->has('business_type_id')) {
            if(is_array($request->business_type_id) && count($request->business_type_id) > 0){
            
                    $business_type_id   = json_encode($request->business_type_id);
                    $business_type = BusinessType::select('name')->where('name','!=',null)->whereIn('id',$request->business_type_id)->get()->toArray();
                    $business_type = (empty($business_type))? null: implode(',', array_column( $business_type,'name' ));
                }    
        }

        if($request->has('association_member_id')) {
            if(is_array($request->association_member_id) && count($request->association_member_id) > 0){
                $association_member_id   = json_encode($request->association_member_id);
                $association_member_name = Association::select('name')->where('name','!=',null)->whereIn('id',$request->association_member_id)->get()->toArray();
                $association_member_name = (empty($association_member_name))? null: implode(',', array_column( $association_member_name,'name' ));
            }
        }


        if(!empty($request->region_id)){
            $region_name = Region::where('id',$request->region_id)->get()->value('name');
        }

        if(!empty($request->country_id)){
            $country_name = Country::where('id',$request->country_id)->get()->value('name');
        }
        $country_name =  (isset($country_name)) ? $country_name : null; 

        if(!empty($request->city_id)){
            $city_name = CityModel::where('id',$request->city_id)->get()->value('name');
        }

        $city_name =  (isset($city_name)) ? $city_name : null;

        if(!empty($request->state_id)){
            $state_name = StateModel::where('id',$request->state_id)->get()->value('name');
        }
         $state_name =  (isset($state_name)) ? $state_name : null; 

            
        $region_name =  (isset($region_name)) ? $region_name : null; 
        // $company_model->company_name = $request->company_name;  

        // $company_model->email = $request->email;  
        // $company_model->status = $request->status;  
        // $company_model->address = $request->address;  
        // $company_model->city_id = $request->city_id;  
        // $company_model->state_id = $request->state_id;  

       // $telephone =  ($request->telephone)? $request->country_code."_".$request->telephone : null;   
        $association_member_id = (isset($association_member_id)) ? $association_member_id : null;  

        $association_member_name = (isset($association_member_name)) ? $association_member_name : null;  

        // $company_model->skype_id = $request->skype_id;  
        // $company_model->website = $request->website; 
        // $company_model->postcode = $request->postcode;  
        // $company_model->permit_no = $request->permit_no;  

        // $company_model->business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
        // $company_model->business_type =  (isset($business_type)) ? $business_type : null; 
        // $company_model->marketing_status = $request->marketing_status;  
        // $company_model->region_id = $request->region_id;  
        
        // $company_model->contact_1_name = $request->contact_1_name;  
        // $company_model->contact_1_email = $request->contact_1_email;  
        // $company_model->contact_1_phone = $request->contact_1_phone;  
        // $company_model->contact_1_designation = $request->contact_1_designation;  
        // $company_model->contact_1_line = isset($request->contact_1_line) ? $request->contact_1_line :'0' ;  
        // $company_model->contact_1_viber = isset($request->contact_1_viber) ? $request->contact_1_viber : '0' ;  
        // $company_model->contact_1_whatsapp = isset($request->contact_1_whatsapp) ? $request->contact_1_whatsapp : '0';  

        // $company_model->contact_2_name = $request->contact_2_name;  
        // $company_model->contact_2_email = $request->contact_2_email;  
        // $company_model->contact_2_phone = $request->contact_2_phone;  
        // $company_model->contact_2_designation = $request->contact_2_designation;  
        // $company_model->deals_in =  (isset($deals_in)) ? $deals_in : null; 
        // $company_model->contact_2_line = isset($request->contact_2_line) ? $request->contact_2_line :'0' ;  
        // $company_model->contact_2_viber = isset($request->contact_2_viber) ? $request->contact_2_viber : '0' ;  
        // $company_model->contact_2_whatsapp = isset($request->contact_2_whatsapp) ? $request->contact_2_whatsapp : '0'; 

        // $company_model->facebook = $request->facebook;  
        // $company_model->instagram = $request->instagram;  
        // $company_model->youtube = $request->youtube;  
        // $company_model->twitter = $request->twitter;  
        // $company_model->linkedin = $request->linkedin;  

          $business_type_id =  (isset($business_type_id)) ? $business_type_id : null;  
         $business_type =  (isset($business_type)) ? $business_type : null;

        $data = [

            "company_name" => $request->company_name,
            "email" => $request->email,
            "city_id" => $request->city_id,
            "city_name" => $city_name,
            "state_id" => $request->state_id,
            "state_name" => $request->state_name,
            "country_id" => $request->country_id,
            "skype_id" => $request->skype_id,
            "website" => $request->website,
            "permit_no" => $request->permit_no,
            "address" => $request->address,
            "telephone" => $telephone,
            "association_member_id" =>$association_member_id,
            "association_member_name" =>$association_member_name,
            "postcode" => $request->postcode,
            "region_id" => $request->region_id,
            "region_name" => $region_name,
            "contact_1_name" => $request->contact_1_name,  
            "contact_1_email" => $request->contact_1_email,  
            "contact_1_phone" => $request->contact_1_phone,  
            "contact_1_designation" => $request->contact_1_designation,  
            "contact_1_line" =>  ($request->contact_1_line) ? $request->contact_1_line :'0' ,  
            "contact_1_viber" => ($request->contact_1_viber) ? $request->contact_1_viber : '0' ,  
            "contact_1_whatsapp" => ($request->contact_1_whatsapp) ? $request->contact_1_whatsapp : '0',  
    
            "contact_2_name" => $request->contact_2_name,  
            "contact_2_email" => $request->contact_2_email,  
            "contact_2_phone" => $request->contact_2_phone,  
            "contact_2_designation" => $request->contact_2_designation,  
            "business_type_id" =>   $business_type_id, 
            "business_type" =>   $business_type, 
            "contact_2_line" => ($request->contact_2_line) ? $request->contact_2_line :'0' ,  
            "contact_2_viber" => ($request->contact_2_viber) ? $request->contact_2_viber : '0' ,  
            "contact_2_whatsapp" => ($request->contact_2_whatsapp) ? $request->contact_2_whatsapp : '0', 


            "facebook" => $request->facebook,  
            "instagram" => $request->instagram,  
            "youtube" => $request->youtube,  
            "twitter" => $request->twitter,  
            "linkedin" => $request->linkedin, 

        ];

         if(CompanyModel::where('company_gabs_id',$company_users->company_id)->update($data)){

            $message = $request->company_name." ".__('webCaption.alert_updated_successfully.title');

            return redirect($this->baseUrl)->with(['success_message' => $message ]);
         }else{
            return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
         }            

    }

}
