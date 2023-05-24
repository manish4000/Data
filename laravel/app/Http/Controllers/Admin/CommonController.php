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
                "name" => $imageName,
                "order_by" => 1,
                'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                "session_id" =>  Session::getId()
            ];

            if(DB::table($request->tempTable)->insert($data)){
                return response()->json([ 'status'=> 'success' , 'name' => $imageName]);
            }
            
        }else{
            return response()->json([ 'status'=> 'failed']);
        }
        
    }


    public function deleteDocument(Request $request){

    

        if($request->id && $request->tempTable){

            $data = DB::table($request->tempTable)->where('id',$request->id)->first();

            if(DB::table($request->tempTable)->where('id',$request->id)->exists()){
                
                if(DB::table($request->tempTable)->where('id',$request->id)->delete()){
                    if(is_file(public_path('/').$request->uploadPath.$data->name )){
                        unlink(public_path('/').$request->uploadPath.$data->name);
                    }
                    return response()->json([ 'status'=> true ,'message' => 'deleted successfully']);
                }else{
                    return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ]);
                }
            }

            if(isset($request->table) && isset($request->name) ){

             $edit_image =   DB::table($request->table)->where('name',$request->name)->first();

             if((isset($edit_image->name)) && (isset($request->editableImagesPath)) ){

                 if(is_file(public_path('/').$request->editableImagesPath.$edit_image->name )){
                     unlink(public_path('/').$request->editableImagesPath.$edit_image->name);
                 }
             }
                if(DB::table($request->table)->where('name',$request->name)->update(['deleted_at' => \Carbon\Carbon::now()->toDateTimeString()])){
                    return response()->json([ 'status'=> true ,'message' => 'deleted successfully']);
                }else{
                    return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ]);
                }
            }


         

           
        }
    }

    public function fetchDocuments(Request $request){

        $session_id = Session::getId();
        $uploadPath = $request->uploadPath;
        $data = DB::table($request->tempTable)->where('session_id',$session_id)->orderBy('created_at','DESC')->first();

            return view('components.admin.view.dropzone-image',['data'=> $data,'uploadPath' => $uploadPath]);


    }
   
}
