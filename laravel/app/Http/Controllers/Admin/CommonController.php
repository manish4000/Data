<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CommonController extends Controller
{   

    public function checkReferanceData(Request $request){

         $data = json_decode($request->data);

          $response_data = [];

        if(count($data) > 0){

            foreach($data as $key => $value ){
               
             $response_data[$key]['count'] =  DB::table($value->table)->where($value->field,$value->value)->count();
             $response_data[$key]['module'] = $value->module;
             $response_data[$key]['url'] = $value->url;

            }
        }
       return response(['response' => $response_data ]) ;
        
    }

    public function uploadDocuments(Request $request){
   
        $image = $request->file('file');
        $imageName = time().rand(100,999).'.'.$image->extension();

        if($image->move(public_path('/').$request->uploadPath,$imageName)){
           
             $data = [
                "file_name" => $imageName,
                "order_by" => 1,
                'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                "session_id" =>  Session::getId()
            ];

            if(DB::table($request->table)->insert($data)){
                return response()->json([ 'status'=> 'success' , 'file_name' => $imageName]);
            }
            
        }else{
            return response()->json([ 'status'=> 'failed']);
        }
        
    }


    public function deleteDocument(Request $request){
        if($request->id && $request->table){

            $data = DB::table($request->table)->where('id',$request->id)->first();

            if(DB::table($request->table)->where('id',$request->id)->delete()){

                if(is_file(public_path('/').$request->uploadPath.$data->file_name )){
                    unlink(public_path('/').$request->uploadPath.$data->file_name);
                }
                return response()->json([ 'status'=> true ,'message' => 'deleted successfully']);
            }else{
                return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ]);
            }
        }
    }

    public function fetchDocuments(Request $request){

        $session_id = Session::getId();

        $data = DB::table($request->table)->where('session_id',$session_id)->orderBy('created_at','DESC')->first();



            return view('components.admin.view.dropzone-image',['data'=> $data]);

        // $view =  view('components.admin.view.dropzone-image',['data'=> $data]);

        // $output = '';

        //         $output .=   '<div class="col-xl-2 col-md-6 col-sm-12 draggable" id="photo'.$data->id.'">
        //         <div class="card">
        //             <div class="card-body m-0 p-0 p-1 image-rotate-manage" id="imgTag'.$data->id.'">
        //                 <img src="'.asset('gabs_companies/documents_temp/'.$data->file_name).'" class="img-fluid rounded" alt="avatar img" />
        //                 <input type="text" name="document_name[]" value="'.$data->file_name.'" >
        //             </div>
        //         <div class="form-group mt-1">
        //             <input type="hidden" name="document[]" value="'.$data->file_name.'" >
        //             <x-admin.form.inputs.text id="" for="website"   name="document_name[]"    required="" />
        //         </div> 

        //         </div>
        //     </div>';
        
        // return response(['image' => $view]);
    }
   
}
