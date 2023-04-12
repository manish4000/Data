<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\Dash\CompanyUsers;
use App\Models\Masters\Country;
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
        $country = Country::get(['id as value' ,'name']);

        $telephone  = (isset($data->telephone) && ($data->telephone != '') && ($data->telephone != null) ) ? explode('_',$data->telephone) : null;
        $data->telephone = ($telephone != null) ? $telephone[1] : null;

        $company_tel_country_code = (isset($telephone[0]))? $telephone[0] :null;  

        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        return view('dash.content.profile',['data'=> $data,'country_phone_code' => $country_phone_code ,'country' => $country ,'company_tel_country_code' => $company_tel_country_code]);

    }


    public function updateProfile(Request $request){



        $request->validate(
            [
            'company_name' => 'required|max:255|unique:companies,company_name,'.$request->id.',company_gabs_id', 
            // 'gabs_uuid' => 'required||max:6|unique:companies_gabs,gabs_uuid,'.$request->id, 
             'email' => 'required|max:45|unique:companies,email,'.$request->id. ',company_gabs_id', 
            'address' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'state_id' => 'nullable|numeric',
            'country_id' => 'nullable|numeric',
            'postcode' => 'nullable|string|max:15',
        
            'telephone' => 'nullable|string|max:20',
            'country_code' => 'required_with:telephone',
            'skype_id'=> 'nullable|string|max:25',
            'website'=> 'nullable|string|max:20',
            ],[
                'company_name.required'=> __('webCaption.validation_required.title', ['field'=> "Company Name" ] ),
                'company_name.max'=> __('webCaption.validation_max.title', ['field'=> "Company Name" ,"max" => "255"] ),
                'company_name.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('company_name') ] ),

                // 'gabs_uuid.required'=> __('webCaption.validation_required.title', ['field'=> "GABS Uuid" ] ),
                // 'gabs_uuid.max'=> __('webCaption.validation_max.title', ['field'=> "GABS Uuid" ,"max" => "6"] ),
                // 'gabs_uuid.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('gabs_uuid') ] ),

                'email.required'=> __('webCaption.validation_required.title', ['field'=> "Email" ] ),
                'email.max'=> __('webCaption.validation_max.title', ['field'=> "Email" ,"max" => "45"] ),
                'email.unique'=> __('webCaption.validation_unique.title', ['field'=> $request->input('email') ] ),

                'address.string'=> __('webCaption.validation_string.title', ['field'=> "Address"] ),

                'city_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "City"] ),
                'state_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "State"] ),
                'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Country"] ),

                'postcode.string'=> __('webCaption.validation_string.title', ['field'=> "Postcode"] ),
                'postcode.max'=> __('webCaption.validation_max.title', ['field'=> "Postcode" ,"max" => "15"] ),

                'telephone.string'=> __('webCaption.validation_string.title', ['field'=> "Telephone"] ),
                'telephone.max'=> __('webCaption.validation_max.title', ['field'=> "Telephone" ,"max" => "20"] ),
                'country_code.required_with' => __('webCaption.validation_required.title', ['field'=> "Country Code" ] ),

                'skype_id.string'=> __('webCaption.validation_string.title', ['field'=> "Skype"] ),
                'skype_id.max'=> __('webCaption.validation_max.title', ['field'=> "Skype" ,"max" => "25"] ),

                'website.string'=> __('webCaption.validation_string.title', ['field'=> "Website"] ),
                'website.max'=> __('webCaption.validation_max.title', ['field'=> "Website" ,"max" => "20"] ),  

            ]
        );


        $user =  Auth::guard('dash')->user();
      
        $company_users =  CompanyUsers::where('company_id',$user->company_id)->where('user_type',1)->first();

        $company_model =   CompanyModel::where('company_gabs_id',$company_users->company_id)->first();

        $telephone = (isset($request->telephone)) ? $request->country_code."_".$request->telephone :null;

        $data = [
            "company_name" => $request->company_name,
            "email" => $request->email,
            "city_id" => $request->city_id,
            "state_id" => $request->state_id,
            "country_id" => $request->country_id,
            "skype_id" => $request->skype_id,
            "website" => $request->website,
            "address" => $request->address,
            "telephone" => $telephone,
            "postcode" => $request->postcode,

        ];

         if(CompanyModel::where('company_gabs_id',$company_users->company_id)->update($data)){

            $message = $request->company_name." ".__('webCaption.alert_updated_successfully.title');

            return redirect($this->baseUrl)->with(['success_message' => $message ]);
         }else{
            return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
         }            

    }

}
