<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;


class VechileMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $jsFileName   =   'master-data-withparent-list.js';
    protected $moduleName   =   'Type';
    protected $basePath     =   '/content/admin/masters/datalist/';
    protected $baseUrl      =   '';
    protected $url;
    protected $dataListCols;
    protected $model;

    public function __construct(Request $request, UrlGenerator $url) {
        $this->url = $url;
        $this->baseUrl =  $this->url->to('/admin/masters/vehicle-type/type');

        $this->model = '\\App\Models\Masters\Vehicles\\';
        switch ($request->model) {
              case 'type':
                  $this->model = '\\App\Models\Masters\Vehicles\\Type';
                  break;
              
              default:
                  # code...
                  break;
          }  

    }


    public function index(Request $request)
    {
        
        $pageConfigs = [
            'pageHeader' => true, 
            'baseUrl' => $this->baseUrl, 
            'moduleName' => $this->moduleName, 
            // 'jsFileName'=> $this->jsFileName,
            // 'dataListCols'  => $this->dataListCols,
            // 'isParentModal' => true
        ];

        $this->breadcrumbs[0] = [
            'link' => $this->baseUrl,
            'name' => 'Add'
        ];

        $data = $this->model::withCount('children');

        //parentOnlyFilter()->

        if(  $request->has('search.keyword')) {
            $data->keywordFilter($request->input('search.keyword')); 
        }
        if(  $request->has('search.displayStatus') && !empty($request->input('search.displayStatus'))) {
            $data->displayStatusFilter($request->input('search.displayStatus')); 
        }
        if(  !$request->has('search.parentOnlyShowAll')) {
            $data->parentOnlyFilter(); 
        } else {
            $data->with('children'); 
        }

        $data = $data->paginate(10);

        return view('content.admin.masters.vechiles.types.list', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $this->breadcrumbs, 'data'=>$data]);
    }

    public function getChildList(Request $request) {
        $records = $this->model::select('id', 'name', 'parent_id', 'display')->orderBy('name', 'ASC')->where('parent_id', $request->itemId)->get();        
        return view('content.admin.masters.vechiles.types.list-loop', ['data'=>$records]);
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
        if(isset($request->id) && $request->id>0)   return $this->update($request);
        else{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:types|max:50'
                ],
                [
                    'name.required' => 'Required '.$this->moduleName,
                    'name.unique' => $this->moduleName.' already exists',
                ]
            );

            if ($validator->fails()) {
                $result['status']     = false;
                $result['icon']       = 'error';
                $result['message'] = $validator->errors();
                return response()->json($result, 200);
            }

            $display = 'No';
            if(isset($request->display))    $display = 'Yes';

            $insert = Type::create([
                'name'      =>  $request->name,
                'parent_id' =>  $request->parent_id,
                'display'   =>  $display
            ]);
            if(isset($insert->id) && $insert->id>0){ 
                $result['status']           = true;
                $result['message']          = 'Successfully Added'; 
                $result['icon']             = 'success'; 
                return response()->json($result);
            }
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
        $data = [];
        if($id>0){
            $__data = Type::FindOrFail($id);
            if(isset($__data->id) && $__data->id>0){
                $data['status'] = true;
                $data['data'] = $__data;                    
            }
            else{
                $data['status']     = false;
                $data['message']    = 'No Records Found!';                
            }
        }
        else{
            $data['status']     = false;
            $data['message']    = 'No Records Found!';                
        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request)
    {
        $result = [];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:types,name,'.$request->id,
            ],
            [
                'name.required' => 'Required '.$this->moduleName,
                'name.unique' => $this->moduleName.' already exists',
            ]
        );

        if ($validator->fails()) {
            $result['status']  = false;
            $result['icon']    = 'error';
            $result['message'] = $validator->errors();
            return response()->json($result, 200);
        }

        $display = 'No';
        if(isset($request->display))    $display = 'Yes';

        $__data = Type::FindOrFail($request->id);
        $__data->name       =   $request->name;
        $__data->parent_id  =   $request->parent_id;
        $__data->display    =   $display;
        $__data->save();

        Type::where('parent_id', $request->id)->update([ 'parent_id' => $request->parent_id]);

        $result['status']     = true;
        $result['message']    = 'Successfully Updated'; 
        $result['icon']       = 'success'; 
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Type::where('id', $id)->firstorfail()->delete();
        $result = [
            'status' => true,
            'icon'  =>  'success',
            'title' =>  'Deleted!',
            'text' => 'Record has been deleted.'
        ];
        return response()->json($result, 200);
    }

    public function updateStatus(Request $request){
        $__data = Type::FindOrFail($request->id);
        $__data->display = $request->display;
        $__data->save();  
        
        $result['status']     = true;
        $result['message']    = 'Successfully Updated'; 
        $result['icon']       = 'success'; 
        return response()->json($result);
    }
}
