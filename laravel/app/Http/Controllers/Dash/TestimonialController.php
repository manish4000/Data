<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Dash\CompanyTestimonial;
use App\Models\Masters\Company\Company;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
use App\Models\Masters\Country;
use Illuminate\Support\Facades\Auth;

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

        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl.'/create',
            'name' => 'Add'
        ];

        $data = CompanyTestimonial::with('country')->select('*');

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 500;

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

        return view('dash.content.testimonial.create',['country' => $country ,'pageConfigs' => $pageConfigs ,'breadcrumbs' => $breadcrumbs ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    
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
            'rating' => 'nullable|numeric|between:0,5',
            'youtube_url' => 'required|url',
            'd_stock_number' => 'required|string',
        ], [
            'title.string' => __('webCaption.validation_string.title', ['field'=> "Title" ] ),
            'posted_date.date' => __('webCaption.validation_date.title', ['field'=> "Posted Date" ] ),
            'posted_date.required' => __('webCaption.validation_required.title', ['field'=> "Posted Date" ] ),
            'description.required' => __('webCaption.validation_required.title', ['field'=> "Description" ] ),
            'person_name.string' => __('webCaption.validation_string.title', ['field'=> "Person Name" ] ),
            'email.email' => __('webCaption.validation_email.title', ['field'=> "Email" ] ),
            'country_id.required' => __('webCaption.validation_required.title', ['field'=> "Country" ] ),
            'country_id.numeric' => __('webCaption.validation_nemuric.title', ['field'=> "Country" ] ),
            'phone.string' => __('webCaption.validation_string.title', ['field'=> "Phone" ] ),
            'phone.max' => __('webCaption.validation_max.title', ['field'=> "Phone" ,"max" => "15" ] ),
            'image.image' => __('webCaption.validation_image.title', ['field'=> "Image" ] ),
            'image.mimes' => __('webCaption.validation_mimes.title', ['field'=> "Image" ,"fileTypes" => "jpeg,png,jpg,gif"] ),
            'image.max' => __('webCaption.validation_max_file.title', ['field'=> "Image" ,"max" => "6120"] ),

            'operator.numeric' => __('webCaption.validation_numeric.title', ['field'=> "Operator" ] ),
            'testimonial_by.required' => __('webCaption.validation_required.title', ['field'=> "Testimonial By" ] ),
            'testimonial_by.in' => __('webCaption.validation_in.title', ['field'=> "Testimonial By" ] ),
            'jct_remark.required' => __('webCaption.validation_required.title', ['field'=> "Jct Remark" ] ),
            'jct_remark.string' => __('webCaption.validation_string.title', ['field'=> "Jct Remark" ] ),

            'testimonials_ref_id.string' => __('webCaption.validation_string.title', ['field'=> "Testimonials Reference Id"] ),
            'rating.numeric' => __('webCaption.validation_numeric.title', ['field'=> "Rating" ] ),
            'rating.between' => __('webCaption.validation_between.title', ['field'=> "Rating" ,"min" => '1' ,"max" => "5"] ),
        
            'youtube_url.required' => __('webCaption.validation_required.title', ['field'=> "Youtube Url" ] ),
            'youtube_url.url' => __('webCaption.validation_url.title', ['field'=> "Youtube Url" ] ),

            'd_stock_number.required' => __('webCaption.validation_required.title', ['field'=> "stock Number" ] ),
            'd_stock_number.string' => __('webCaption.validation_string.title', ['field'=> "stock Number" ] ),

        ]        
        );


        if($request->id){
            $testmonail_model =  CompanyTestimonial::find($request->id);
        }else{
            $testmonail_model =  new CompanyTestimonial();
        }

            $user =   Auth::guard('dash')->user();
            $folder =     Company::where('id',$user->company_id)->value('gabs_uuid');   

            $testmonail_model->title = $request->title; 
            $testmonail_model->company_user_id = $user->company_id; 
            $testmonail_model->posted_date = $request->posted_date; 
            $testmonail_model->description = $request->description; 
            $testmonail_model->person_name = $request->person_name; 
            $testmonail_model->email = $request->email; 
            $testmonail_model->country_id = $request->country_id; 
            $testmonail_model->phone = $request->phone; 
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
                $image = time().'.'.$request->image->extension();  
                $request->image->move(public_path('company_data').'/'.$folder.'/testimonials', $image);
                $testmonail_model->image = $image;
            }

            if($request->has('vehicle_image')){
                $vehicle_image = time().'.'.$request->vehicle_image->extension();  
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
        $data =  CompanyTestimonial::find($id);

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
        $imageFolder =     Company::where('id',$user->company_id)->value('gabs_uuid'); 

        return view('dash.content.testimonial.create',['pageConfigs' => $pageConfigs ,'imageFolder' => $imageFolder ,'breadcrumbs' => $breadcrumbs ,'data' => $data ,'country' => $country]);
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
            if(CompanyTestimonial::where('id', $request->id)->firstorfail()->delete()){
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

        // if (!Auth::user()->can('masters-vehicle-type-delete')) {
        //     $result['status']     = false;
        //     $result['message']    = __('webCaption.alert_delete_access.title'); 
        //     return response()->json(['result' => $result]);
        //     abort(403);
        // }

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
