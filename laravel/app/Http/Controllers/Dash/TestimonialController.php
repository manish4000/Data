<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\CompanyGabsModel;
use App\Models\Dash\CompanyTestimonial;
use App\Models\Masters\Company\Company;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
use App\Models\Masters\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{   
    protected $moduleName   =   'Testimonial';
    protected $basePath     =   '';
    protected $baseUrl      =   '';
    protected $url;
    protected $dataListCols;


    // $this->status = json_decode(json_encode($this->status));

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/testimonial');
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (!Auth::guard('dash')->user()->can('common-testimonial')) {
            abort(403);
        }

        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 
        ];


        if (Auth::guard('dash')->user()->can('common-testimonial-add')) {
            $breadcrumbs[0] = [
                'link' => $this->baseUrl.'/create',
                'name' => __('webCaption.add.title')
            ];
        }else{
            $breadcrumbs[0] = [ ];
        } 

        $data = CompanyTestimonial::with('country')->select('*');

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        if(  !empty($request->input('search.keyword') ) ) {
            $data->keywordFilter($request->input('search.keyword')); 
        }

        if($request->has('order_by') &&  $request->has('order') ){
            $data->orderBy($request->order_by, $request->order);
        }

        $data = $data->paginate($perPage);
        return view('dash.content.testimonial.index',['pageConfigs' => $pageConfigs ,'breadcrumbs' => $breadcrumbs ,'data' => $data ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        if (!Auth::guard('dash')->user()->can('common-testimonial-add')) {
            abort(403);
        }
        $country = Country::get(['id as value' ,'name']);
        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 

        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'List'
        ];
        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        return view('dash.content.testimonial.create',['country' => $country ,'country_phone_code' => $country_phone_code ,'pageConfigs' => $pageConfigs ,'breadcrumbs' => $breadcrumbs ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (!Auth::guard('dash')->user()->can('common-testimonial-add')) {
            abort(403);
        }
    
        $request->validate([
            'title' => 'string|nullable',
            'posted_date' => 'required|date',
            'description' => 'required',
            'person_name' => 'nullable|string',
            'email' => 'nullable|email',
            'country_id' => 'required|numeric',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
            'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
            'operator' => 'nullable|numeric',
            'testimonial_by' => 'required|in:Buyer,Dealer',
            'jct_remark' => 'required|string',
            'testimonials_ref_id' => 'nullable|string',
            'rating' => 'nullable|numeric',
            'youtube_url' => 'required|url',
            'd_stock_number' => 'required|string',
        ], [
            'title.string' => __('webCaption.validation_string.title', ['field'=>__('webCaption.title.title') ] ),
            'posted_date.date' => __('webCaption.validation_date.title', ['field'=> __('webCaption.posted_date.title') ] ),
            'posted_date.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.posted_date.title') ] ),
            'description.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.description.title') ] ),
            'person_name.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.person_name.title') ] ),
            'email.email' => __('webCaption.validation_email.title', ['field'=> __('webCaption.email.title') ] ),
            'country_id.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.country.title') ] ),
            'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> __('webCaption.country.title') ] ),
            'phone.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.phone.title') ] ),
            'phone.max' => __('webCaption.validation_max.title', ['field'=> __('webCaption.phone.title') ,"max" => "15" ] ),
            'image.image' => __('webCaption.validation_image.title', ['field'=> __('webCaption.image.title') ] ),
            'image.mimes' => __('webCaption.validation_mimes.title', ['field'=> __('webCaption.image.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'image.max' => __('webCaption.validation_max_file.title', ['field'=> __('webCaption.image.title') ,"max" => "6120"] ),

            'operator.numeric' => __('webCaption.validation_numeric.title', ['field'=> "Operator" ] ),
            'testimonial_by.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.testimonial_by.title') ] ),
            'testimonial_by.in' => __('webCaption.validation_in.title', ['field'=> __('webCaption.testimonial_by.title') ] ),
            'jct_remark.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.jct_remark.title')] ),
            'jct_remark.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.jct_remark.title')] ),

            'testimonials_ref_id.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.jct_remark.title') ] ),
            'rating.numeric' => __('webCaption.validation_numeric.title', ['field'=> __('webCaption.rating.title') ] ),
            'youtube_url.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.youtube_url.title') ] ),
            'youtube_url.url' => __('webCaption.validation_url.title', ['field'=> __('webCaption.youtube_url.title') ] ),

            'd_stock_number.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.stock_number.title') ] ),
            'd_stock_number.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.stock_number.title') ] ),

        ]        
        );


        if($request->id){
            $testmonail_model =  CompanyTestimonial::find($request->id);
        }else{
            $testmonail_model =  new CompanyTestimonial();
        }

            $user =   Auth::guard('dash')->user();
            $folder =     CompanyGabsModel::where('id',$user->company_id)->value('gabs_uuid');   

            $testmonail_model->title = $request->title; 
            $testmonail_model->company_user_id = $user->company_id; 
            $testmonail_model->posted_date = $request->posted_date; 
            $testmonail_model->description = $request->description; 
            $testmonail_model->person_name = $request->person_name; 
            $testmonail_model->email = $request->email; 
            $testmonail_model->country_id = $request->country_id; 
            $testmonail_model->phone = $request->country_code."_".$request->phone; 
            $testmonail_model->testimonial_by = $request->testimonial_by; 
            $testmonail_model->show_person_name = ($request->has('show_person_name')) ? 1 :0; 
            $testmonail_model->jct_remark = $request->jct_remark; 
            $testmonail_model->show_jct_remark = ($request->has('show_jct_remark')) ? 1 :0; 
            $testmonail_model->testimonials_ref_id = 0; 
            $testmonail_model->rating = isset($request->rating)? $request->rating : 0; 
            $testmonail_model->youtube_url = $request->youtube_url; 
            $testmonail_model->image_url = "https://test/"; 
            $testmonail_model->d_stock_number = $request->d_stock_number;
            $testmonail_model->verified_buyer = ($request->has('verified_buyer')) ? 1 :0;  
            $testmonail_model->is_paid =  1  ;
            $testmonail_model->operator = 0; 

            if($request->has('image')){
                $image = time().rand(11111,99999).'.'.$request->image->extension();  
                $request->image->move(public_path('company_data').'/'.$folder.'/testimonials', $image);
                $testmonail_model->image = $image;
            }

            if($request->has('vehicle_image')){
                $vehicle_image = time().rand(11111,99999).'.'.$request->vehicle_image->extension();  
                $request->vehicle_image->move(public_path('company_data').'/'.$folder.'/testimonials', $vehicle_image);
                $testmonail_model->vehicle_image = $vehicle_image;
            }

            if($testmonail_model->save()){

                $message = (isset($request->id)) ? $request->title." ".__('webCaption.alert_updated_successfully.title') : $request->title." ".__('webCaption.alert_added_successfully.title');

                return redirect($this->baseUrl)->with(['success_message' => $message ]);
            }else{
                return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ' ]);
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
        
        if (!Auth::guard('dash')->user()->can('common-testimonial-edit')) {
            abort(403);
        }

        $data =  CompanyTestimonial::find($id);

        $phone                = (isset($data->phone)) ? explode('_',$data->phone) : null;
        $data->phone = ($phone != null) ? $phone[1] : null;
        $country_code = (isset($phone[0]))? $phone[0] :'';


        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 

        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'List'
        ];

        $country = Country::get(['id as value' ,'name']);
        $user =   Auth::guard('dash')->user();
        $imageFolder =     CompanyGabsModel::where('id',$user->company_id)->value('gabs_uuid'); 
        $country_phone_code =  Country::select('phone_code as value' ,'country_code' ,DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code','!=' ,null)->where('country_code','!=' ,null)->get(['phone_code','country_code']);

        return view('dash.content.testimonial.create',['pageConfigs' => $pageConfigs,'country_code' => $country_code,'country_phone_code' => $country_phone_code ,'imageFolder' => $imageFolder ,'breadcrumbs' => $breadcrumbs ,'data' => $data ,'country' => $country]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user =   Auth::guard('dash')->user();

        $folder =     CompanyGabsModel::where('id',$user->company_id)->value('gabs_uuid');   
        
        if (!Auth::guard('dash')->user()->can('common-testimonial-delete')) {
            abort(403);
        }

        $company_testmonial_model =   CompanyTestimonial::FindOrFail($request->id);

        $user_image = $company_testmonial_model->image;
        $vehicle_image = $company_testmonial_model->vehicle_image;

        if($company_testmonial_model->delete()){

            if(is_file(public_path('company_data').'/'.$folder.'/testimonials/'.$user_image )){

                unlink(public_path('company_data').'/'.$folder.'/testimonials/'.$user_image);
            }
            
            if(is_file(public_path('company_data').'/'.$folder.'/testimonials/'.$vehicle_image )){

                unlink(public_path('company_data').'/'.$folder.'/testimonials/'.$vehicle_image);
            }


            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title'); 
        
           return response()->json(['result' => $result]);

        }else{
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title'); 
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple(Request $request){

        if (!Auth::guard('dash')->user()->can('common-testimonial-delete')) {
            abort(403);
        }

        if(CompanyTestimonial::whereIn('id', $request->delete_ids)->delete()){
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
