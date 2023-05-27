<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\CompanyGabsModel;
use App\Models\Dash\CompanyTestimonial;
use App\Models\Dash\TestmonialImagesModel;
use App\Models\DashTempImagesModel;
use App\Models\Masters\Company\Company;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
use App\Models\Masters\Country;
use App\Models\StateModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use File;

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
                'link' => $this->baseUrl . '/create',
                'name' => __('webCaption.add.title')
            ];
        } else {
            $breadcrumbs[0] = [];
        }

        $data = CompanyTestimonial::with('country')->select('*');

        $perPage =  (isset($request->perPage) && !empty($request->perPage)) ? $request->perPage : 100;

        if (!empty($request->input('search.keyword'))) {
            $data->keywordFilter($request->input('search.keyword'));
        }

        if ($request->has('order_by') &&  $request->has('order')) {
            $data->orderBy($request->order_by, $request->order);
        }

        $data = $data->paginate($perPage);

        return view('dash.content.testimonial.index', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs, 'data' => $data]);
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

        $country = Country::get(['id as value', 'name']);

        $pageConfigs = [
            'pageHeader' => true,
            'baseUrl' => $this->baseUrl,
            'moduleName' => $this->moduleName,
        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'List'
        ];

        $country_phone_code =  Country::select('phone_code as value', 'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code', '!=', null)->where('country_code', '!=', null)->get(['phone_code', 'country_code']);

        return view('dash.content.testimonial.create', ['country' => $country, 'country_phone_code' => $country_phone_code, 'pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $old_buyer_image_name = '';
        $old_user_image_name = '';
        $old_vehicle_image_name = '';

        if (!Auth::guard('dash')->user()->can('common-testimonial-add')) {
            abort(403);
        }

        $request->validate(
            [
                'title' => 'string|nullable',
                'posted_date' => 'required|date',
                'description' => 'required',
                'person_name' => 'nullable|string',
                'email' => 'nullable|email',
                'country' => 'required|numeric',
                'city' => 'nullable|numeric',
                'state'  => 'nullable|numeric',
                'phone' => 'nullable|string|max:15',
                //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
                'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
                'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
                'buyer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6120',
                'operator' => 'nullable|numeric',
                'testimonial_by' => 'required|in:Buyer,Dealer',
                'jct_remark' => 'nullable|string',
                'testimonials_ref_id' => 'nullable|string',
                'rating' => 'nullable|numeric',
                'youtube_url' => 'nullable|url',
                //'d_stock_number' => 'nullable|string',
            ],
            [
                'title.string' => __('webCaption.validation_string.title', ['field' => __('webCaption.title.title')]),
                'posted_date.date' => __('webCaption.validation_date.title', ['field' => __('webCaption.posted_date.title')]),
                'posted_date.required' => __('webCaption.validation_required.title', ['field' => __('webCaption.posted_date.title')]),
                'description.required' => __('webCaption.validation_required.title', ['field' => __('webCaption.description.title')]),
                'person_name.string' => __('webCaption.validation_string.title', ['field' => __('webCaption.person_name.title')]),
                'email.email' => __('webCaption.validation_email.title', ['field' => __('webCaption.email.title')]),
                'country.required' => __('webCaption.validation_required.title', ['field' => __('webCaption.country.title')]),
                'country.numeric' => __('webCaption.validation_nemuric.title', ['field' => __('webCaption.country.title')]),
                'city.numeric' => __('webCaption.validation_nemuric.title', ['field' => __('webCaption.city.title')]),
                'state.numeric' => __('webCaption.validation_nemuric.title', ['field' => __('webCaption.state.title')]),
                'phone.string' => __('webCaption.validation_string.title', ['field' => __('webCaption.phone.title')]),
                'phone.max' => __('webCaption.validation_max.title', ['field' => __('webCaption.phone.title'), "max" => "15"]),
                // 'image.image' => __('webCaption.validation_image.title', ['field'=> __('webCaption.image.title') ] ),
                // 'image.mimes' => __('webCaption.validation_mimes.title', ['field'=> __('webCaption.image.title') ,"fileTypes" => "jpeg,png,jpg,gif"] ),
                // 'image.max' => __('webCaption.validation_max_file.title', ['field'=> __('webCaption.image.title') ,"max" => "6120"] ),

                'vehicle_image.image' => __('webCaption.validation_image.title', ['field' => __('webCaption.vehicle_image.title')]),
                'vehicle_image.mimes' => __('webCaption.validation_mimes.title', ['field' => __('webCaption.vehicle_image.title'), "fileTypes" => "jpeg,png,jpg,gif"]),
                'vehicle_image.max' => __('webCaption.validation_max_file.title', ['field' => __('webCaption.vehicle_image.title'), "max" => "6120"]),

                'user_image.image' => __('webCaption.validation_image.title', ['field' => __('webCaption.user_image.title')]),
                'user_image.mimes' => __('webCaption.validation_mimes.title', ['field' => __('webCaption.user_image.title'), "fileTypes" => "jpeg,png,jpg,gif"]),
                'user_image.max' => __('webCaption.validation_max_file.title', ['field' => __('webCaption.user_image.title'), "max" => "6120"]),

                'buyer_image.image' => __('webCaption.validation_image.title', ['field' => __('webCaption.buyer_image.title')]),
                'buyer_image.mimes' => __('webCaption.validation_mimes.title', ['field' => __('webCaption.buyer_image.title'), "fileTypes" => "jpeg,png,jpg,gif"]),
                'buyer_image.max' => __('webCaption.validation_max_file.title', ['field' => __('webCaption.buyer_image.title'), "max" => "6120"]),

                'operator.numeric' => __('webCaption.validation_numeric.title', ['field' => "Operator"]),
                'testimonial_by.required' => __('webCaption.validation_required.title', ['field' => __('webCaption.testimonial_by.title')]),
                'testimonial_by.in' => __('webCaption.validation_in.title', ['field' => __('webCaption.testimonial_by.title')]),
                // 'jct_remark.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.jct_remark.title')] ),
                'jct_remark.string' => __('webCaption.validation_string.title', ['field' => __('webCaption.jct_remark.title')]),

                'testimonials_ref_id.string' => __('webCaption.validation_string.title', ['field' => __('webCaption.jct_remark.title')]),
                'rating.numeric' => __('webCaption.validation_numeric.title', ['field' => __('webCaption.rating.title')]),
                // 'youtube_url.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.youtube_url.title') ] ),
                'youtube_url.url' => __('webCaption.validation_url.title', ['field' => __('webCaption.youtube_url.title')]),

                // 'd_stock_number.required' => __('webCaption.validation_required.title', ['field'=> __('webCaption.stock_number.title') ] ),
                //'d_stock_number.string' => __('webCaption.validation_string.title', ['field'=> __('webCaption.stock_number.title') ] ),

            ]
        );


        if ($request->id) {
            $testmonail_model =  CompanyTestimonial::find($request->id);

            $old_buyer_image_name = $testmonail_model->buyer_image;
            $old_user_image_name = $testmonail_model->user_image;
            $old_vehicle_image_name = $testmonail_model->vehicle_image;
        } else {
            $testmonail_model =  new CompanyTestimonial();
        }

        $user =   Auth::guard('dash')->user();
        $folder =   CompanyGabsModel::where('id', $user->company_id)->value('gabs_uuid');

        $testmonail_model->status =  $request->display_status;
        $testmonail_model->title = $request->title;
        $testmonail_model->company_user_id = $user->company_id;
        $testmonail_model->posted_date = $request->posted_date;
        $testmonail_model->description = $request->description;
        $testmonail_model->name_title = $request->name_title;
        $testmonail_model->person_name = $request->person_name;
        $testmonail_model->email = $request->email;

        $testmonail_model->country_id = $request->country;
        $country = Country::select('name')->where('id', $request->country)->get()->value('name');
        $testmonail_model->country = $country;

        $testmonail_model->state_id  =  $request->state;
        $state = StateModel::select('name')->where('id', $request->state)->get()->value('name');
        $testmonail_model->state = $state;

        $testmonail_model->city_id = $request->city;
        $city = CityModel::select('name')->where('id', $request->city)->get()->value('name');
        $testmonail_model->city = $city;

        $testmonail_model->phone = $request->country_code . "_" . $request->phone;
        $testmonail_model->testimonial_by = $request->testimonial_by;
        $testmonail_model->show_person_name = ($request->has('show_person_name')) ? 1 : 0;
        $testmonail_model->jct_remark = $request->jct_remark;
        $testmonail_model->show_jct_remark = ($request->has('show_jct_remark')) ? 1 : 0;
        $testmonail_model->testimonials_ref_id = 0;

        $testmonail_model->rating = isset($request->rating) ? $request->rating : 0;
        $testmonail_model->youtube_url = $request->youtube_url;
        $testmonail_model->image_url = "https://test/";
        // $testmonail_model->d_stock_number = $request->d_stock_number;
        $testmonail_model->verified_buyer = ($request->has('verified_buyer')) ? 1 : 0;
        $testmonail_model->is_paid =  1;
        $testmonail_model->operator = 0;
        $testmonail_model->admin_memo = $request->admin_memo;

        if ($request->has('user_image')) {
            $width = getImageSize($request->user_image)[0];
            $height = getImageSize($request->user_image)[1];

            $user_image = $request->file('user_image');
            $new_user_image = time() . '.' . $user_image->getClientOriginalExtension();

            if ($width > 1000 && $height > 800) {
                $destinationPath = public_path('/company_data/testimonials/small_user_image');
                $imgFile = Image::make($user_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_user_image);

                $destinationPath = public_path('/company_data/testimonials/user_image');
                $imgFile = Image::make($user_image->getRealPath());
                $imgFile->resize(1000, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_user_image);
            } elseif (($width > 400 && $width < 1000) && ($height > 300 && $height < 800)) {
                $destinationPath = public_path('/company_data/testimonials/small_user_image');
                $imgFile = Image::make($user_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_user_image);

                $destinationPath = public_path('/company_data/testimonials/user_image');
                $user_image->move($destinationPath, $new_user_image);

            } else {
                $destinationPath = public_path('/company_data/testimonials/small_user_image');
                $user_image->move($destinationPath, $new_user_image);
                $new_path = public_path('/company_data/testimonials/user_image/');
                copy($destinationPath.'/'.$new_user_image,$new_path.$new_user_image);
            }

            $testmonail_model->user_image  =  $new_user_image;
        }

        if ($request->has('vehicle_image')) {
            $width = getImageSize($request->vehicle_image)[0];
            $height = getImageSize($request->vehicle_image)[1];

            $vehicle_image = $request->file('vehicle_image');
            $new_vehicle_image = time() . '.' . $vehicle_image->getClientOriginalExtension();

            if ($width > 1000 && $height > 800) {
                $destinationPath = public_path('/company_data/testimonials/small_vehicle_image');
                $imgFile = Image::make($vehicle_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_vehicle_image);

                $destinationPath = public_path('/company_data/testimonials/vehicle_image');
                $imgFile = Image::make($vehicle_image->getRealPath());
                $imgFile->resize(1000, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_vehicle_image);
            } elseif (($width > 400 && $width < 1000) && ($height > 300 && $height < 800)) {
                $destinationPath = public_path('/company_data/testimonials/small_vehicle_image');
                $imgFile = Image::make($vehicle_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_vehicle_image);

                $destinationPath = public_path('/company_data/testimonials/vehicle_image');
                $vehicle_image->move($destinationPath, $new_vehicle_image);
                
            } else {
                $destinationPath = public_path('/company_data/testimonials/small_vehicle_image');
                $vehicle_image->move($destinationPath, $new_vehicle_image);
                $new_path = public_path('/company_data/testimonials/vehicle_image/');
                copy($destinationPath.'/'.$new_vehicle_image,$new_path.$new_vehicle_image);
            }

            $testmonail_model->vehicle_image  =  $new_vehicle_image;
        }

        if ($request->has('buyer_image')) {
            $width = getImageSize($request->buyer_image)[0];
            $height = getImageSize($request->buyer_image)[1];

            $buyer_image = $request->file('buyer_image');
            $new_buyer_image = time() . '.' . $buyer_image->getClientOriginalExtension();

            if ($width > 1000 && $height > 800) {
                $destinationPath = public_path('/company_data/testimonials/small_buyer_image');
                $imgFile = Image::make($buyer_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_buyer_image);

                $destinationPath = public_path('/company_data/testimonials/buyer_image');
                $imgFile = Image::make($buyer_image->getRealPath());
                $imgFile->resize(1000, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_buyer_image);
            } elseif (($width > 400 && $width < 1000) && ($height > 300 && $height < 800)) {
                $destinationPath = public_path('/company_data/testimonials/small_buyer_image');
                $imgFile = Image::make($buyer_image->getRealPath());

                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $new_buyer_image);

                $destinationPath = public_path('/company_data/testimonials/buyer_image');
                $buyer_image->move($destinationPath, $new_buyer_image);
                
            } else {
                $destinationPath = public_path('/company_data/testimonials/small_buyer_image');
                $buyer_image->move($destinationPath, $new_buyer_image);
                $new_path = public_path('/company_data/testimonials/buyer_image/');
                copy($destinationPath.'/'.$new_buyer_image,$new_path.$new_buyer_image);
            }

            $testmonail_model->buyer_image  =  $new_buyer_image;
        }
        // if ($request->has('vehicle_image')) {
        //     $vehicle_image = time() . '.' . $request->vehicle_image->extension();
        //     $request->vehicle_image->move(public_path('company_data/testimonials/vehicle_image'), $vehicle_image);
        //     $testmonail_model->vehicle_image  =  $vehicle_image;

        //     if (is_file(public_path('company_data/testimonials/vehicle_image') . '/' . $old_vehicle_image_name)) {
        //         unlink(public_path('company_data/testimonials/vehicle_image') . '/' . $old_vehicle_image_name);
        //     }
        // }

        // if ($request->has('buyer_image')) {
        //     $buyer_image = time() . '.' . $request->buyer_image->extension();
        //     $request->buyer_image->move(public_path('company_data/testimonials/buyer_image'), $buyer_image);
        //     $testmonail_model->buyer_image  =  $buyer_image;

        //     if (is_file(public_path('company_data/testimonials/buyer_image') . '/' . $old_buyer_image_name)) {
        //         unlink(public_path('company_data/testimonials/buyer_image') . '/' . $old_buyer_image_name);
        //     }
        // }

        if ($testmonail_model->save()) {

            $testmonial_id = (isset($testmonail_model->id)) ? $testmonail_model->id : $request->id;

            if ($request->has('document')) {

                $dash_temp_images  = new DashTempImagesModel();

                $company_testmimonal_images = new TestmonialImagesModel();

                $newFolder = public_path('company_data/' . $folder . '/testimonials');

                if (!File::isDirectory($newFolder)) {
                    File::makeDirectory($newFolder, 0777, true, true);
                }

                if ($request->id) {

                    $company_testmimonal_images->where('company_testimonial_id', $testmonial_id)->delete();

                    foreach ($request->document as $key => $document) {

                        $from = public_path('dash/documents_temp/') . $document;

                        $to = public_path('company_data/' . $folder . '/testimonials') . '/' . $document;

                        if (!is_file($to)) {
                            File::move($from, $to);
                        }

                        $document_file['company_testimonial_id'] = $testmonial_id;
                        $document_file['image'] = $document;

                        $document_file['image_name'] = (isset($request->document_name[$key])) ? $request->document_name[$key] : 'null';;
                        $document_file['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
                        $document_file['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();

                        $company_testmimonal_images->insert($document_file);

                        //delete the temp file from database 

                        $dash_temp_images->where('name', $document)->delete();

                        $document_file = [];
                    }
                } else {

                    foreach ($request->document as $key => $document) {

                        $from = public_path('dash/documents_temp/') . $document;

                        $to = public_path('company_data') . '/' . $folder . '/testimonials' . $document;

                        if (File::move($from, $to)) {
                        }
                        $document_file['company_testimonial_id'] = $testmonial_id;
                        $document_file['image'] = $document;

                        $document_file['image_name'] = (isset($request->document_name[$key])) ? $request->document_name[$key] : 'null';;
                        $document_file['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
                        $document_file['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();

                        $company_testmimonal_images->insert($document_file);

                        //delete the temp file from database 

                        $dash_temp_images->where('name', $document)->delete();

                        $document_file = [];
                    }
                }
            }


            $message = (isset($request->id)) ? $request->title . " " . __('webCaption.alert_updated_successfully.title') : $request->title . " " . __('webCaption.alert_added_successfully.title');

            return redirect($this->baseUrl)->with(['success_message' => $message]);
        } else {
            return redirect($this->baseUrl)->with(['error_message' => ' Somthing Went Wrong ... ']);
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

        $data =  CompanyTestimonial::with('images')->find($id);

        $phone       = (isset($data->phone)) ? explode('_', $data->phone) : null;
        $data->phone = ($phone != null) ? $phone[1] : null;
        $country_code = (isset($phone[0])) ? $phone[0] : '';


        $pageConfigs = [
            'pageHeader' => true,
            'baseUrl' => $this->baseUrl,
            'moduleName' => $this->moduleName,

        ];
        $breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'List'
        ];

        $country = Country::get(['id as value', 'name']);
        $user =   Auth::guard('dash')->user();
        $imageFolder =     CompanyGabsModel::where('id', $user->company_id)->value('gabs_uuid');
        $country_phone_code =  Country::select('phone_code as value', 'country_code', DB::raw("CONCAT(country_code,' (',phone_code ,')' ) AS name"))->where('phone_code', '!=', null)->where('country_code', '!=', null)->get(['phone_code', 'country_code']);

        return view('dash.content.testimonial.create', ['pageConfigs' => $pageConfigs, 'country_code' => $country_code, 'country_phone_code' => $country_phone_code, 'imageFolder' => $imageFolder, 'breadcrumbs' => $breadcrumbs, 'data' => $data, 'country' => $country]);
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

        $folder =     CompanyGabsModel::where('id', $user->company_id)->value('gabs_uuid');

        if (!Auth::guard('dash')->user()->can('common-testimonial-delete')) {
            abort(403);
        }

        $data = CompanyTestimonial::find($request->id);

        if ((is_file(public_path('company_data/testimonials/user_image') . '/' . $data->user_image)) && (is_file(public_path('company_data/testimonials/small_user_image') . '/' . $data->user_image)) ) {
            unlink(public_path('company_data/testimonials/user_image') . '/' . $data->user_image);
            unlink(public_path('company_data/testimonials/small_user_image') . '/' . $data->user_image);
        }

        if ((is_file(public_path('company_data/testimonials/buyer_image') . '/' . $data->buyer_image)) && (is_file(public_path('company_data/testimonials/small_buyer_image') . '/' . $data->buyer_image))) {
            unlink(public_path('company_data/testimonials/buyer_image') . '/' . $data->buyer_image);
            unlink(public_path('company_data/testimonials/small_buyer_image') . '/' . $data->buyer_image);
        }

        if ((is_file(public_path('company_data/testimonials/vehicle_image') . '/' . $data->vehicle_image)) && (is_file(public_path('company_data/testimonials/small_vehicle_image') . '/' . $data->vehicle_image)) ) {
            unlink(public_path('company_data/testimonials/vehicle_image') . '/' . $data->vehicle_image);
            unlink(public_path('company_data/testimonials/small_vehicle_image') . '/' . $data->vehicle_image);
        }

        $company_testmonial_model =   CompanyTestimonial::FindOrFail($request->id);

        $user_image = $company_testmonial_model->image;
        $vehicle_image = $company_testmonial_model->vehicle_image;

        if ($company_testmonial_model->delete()) {

            if (is_file(public_path('company_data') . '/' . $folder . '/testimonials/' . $user_image)) {

                unlink(public_path('company_data') . '/' . $folder . '/testimonials/' . $user_image);
            }

            if (is_file(public_path('company_data') . '/' . $folder . '/testimonials/' . $vehicle_image)) {

                unlink(public_path('company_data') . '/' . $folder . '/testimonials/' . $vehicle_image);
            }


            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title');

            return response()->json(['result' => $result]);
        } else {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title');
            return response()->json(['result' => $result]);
        }
    }

    public function deleteMultiple(Request $request)
    {

        if (!Auth::guard('dash')->user()->can('common-testimonial-delete')) {
            abort(403);
        }

        $data = CompanyTestimonial::whereIn('id', $request->delete_ids)->get();

        foreach ($data as $item) {
            if ((is_file(public_path('company_data/testimonials/user_image') . '/' . $item->user_image)) && (is_file(public_path('company_data/testimonials/small_user_image') . '/' . $item->user_image))) {
                unlink(public_path('company_data/testimonials/user_image') . '/' . $item->user_image);
                unlink(public_path('company_data/testimonials/small_user_image') . '/' . $item->user_image);
            }

            if ((is_file(public_path('company_data/testimonials/vehicle_image') . '/' . $item->vehicle_image)) && (is_file(public_path('company_data/testimonials/small_vehicle_image') . '/' . $item->vehicle_image))) {
                unlink(public_path('company_data/testimonials/vehicle_image') . '/' . $item->vehicle_image);
                unlink(public_path('company_data/testimonials/small_vehicle_image') . '/' . $item->vehicle_image);
            }

            if ((is_file(public_path('company_data/testimonials/buyer_image') . '/' . $item->buyer_image)) && (is_file(public_path('company_data/testimonials/small_buyer_image') . '/' . $item->buyer_image))) {
                unlink(public_path('company_data/testimonials/buyer_image') . '/' . $item->buyer_image);
                unlink(public_path('company_data/testimonials/small_buyer_image') . '/' . $item->buyer_image);
            }
        }

        if (CompanyTestimonial::whereIn('id', $request->delete_ids)->delete()) {
            $result['status']     = true;
            $result['message']    = __('webCaption.alert_deleted_successfully.title');
            return response()->json(['result' => $result]);
        } else {
            $result['status']     = false;
            $result['message']    = __('webCaption.alert_somthing_wrong.title');
            return response()->json(['result' => $result]);
        }
    }
}
