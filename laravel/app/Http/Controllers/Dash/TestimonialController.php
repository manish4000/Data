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

        $data = CompanyTestimonial::select('*');

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
        return view('dash.content.testimonial.create',['country' => $country]);
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
            'posted_date' => 'nullable|date',
            'description' => 'required',
            'person_name' => 'nullable|string',
            'email' => 'nullable|email',
            'country_id' => 'required|numeric',
            'phone' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
            'vehicle_image' => 'required||image|mimes:jpeg,png,jpg,gif|max:6120',
            'operator' => 'nullable|numeric',
            'testimonial_by' => 'required|in:Buyer,Dealer',
            'jct_remark' => 'required|string',
            'testimonials_ref_id' => 'nullable|string',
            'rating' => 'nullable|numeric|between:1,5',
            'youtube_url' => 'required|url',
            'd_stock_number' => 'required|string',
        ]);


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
            $testmonail_model->rating = isset($request->rating)? $request->rating : ''; 
            $testmonail_model->youtube_url = $request->youtube_url; 
            $testmonail_model->image_url = "https://test/"; 
            $testmonail_model->d_stock_number = $request->d_stock_number; 
            $testmonail_model->vehicle_image = $request->vehicle_image; 
            $testmonail_model->verified_buyer = ($request->has('verified_buyer')) ? 1 :0;  
            $testmonail_model->is_paid = ($request->has('show_jct_remark')) ? 1 :0;  ; 
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
