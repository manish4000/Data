<?php

namespace App\Http\Controllers\Dash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Image;

class CommonController extends Controller
{   

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

           // $imagePath = public_path('/').$request->uploadPath.'/'.$imageName;
            // $imagePath = 'public_html/assets/dash/assets/images/banklogo/bank_logo_image.png';

            // $img = Image::make(public_path('images/jct_icon.png'));
            // $img->rotate(90);
            // $img->save('images/jct_icon.png');
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
                    return response()->json([ 'status'=> true ,'message' => 'deleted successfully' ,'deleted_img_id' => $request->id]);
                }else{
                    return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ]);
                }
            }

            if(isset($request->table) && isset($request->name) ){

             $edit_image =   DB::table($request->table)->where($request->fieldName,$request->name)->first();

             if((isset($edit_image->name)) && (isset($request->editableImagesPath)) ){

                 if(is_file(public_path('/').$request->editableImagesPath.$edit_image->name )){
                     unlink(public_path('/').$request->editableImagesPath.$edit_image->name);
                 }
             }
                if(DB::table($request->table)->where($request->fieldName,$request->name)->update(['deleted_at' => \Carbon\Carbon::now()->toDateTimeString()])){
                    return response()->json([ 'status'=> true ,'deleted_img_id' => $request->id]);
                }else{
                    return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ,'deleted_img_id' => $request->id ]);
                }
            }


         

           
        }
    }

    public function rotateImage(Request $request){

    
        $rand_val = "?".rand(100,999);
        if(is_file(public_path('/').$request->uploadPath.'/'.$request->name )){
            $imagePath = public_path('/').$request->uploadPath.'/'.$request->name;
            $image_src = asset('/').$request->uploadPath.'/'.$request->name.$rand_val;
        }else{
            $imagePath = public_path('/').$request->editableImagesPath.'/'.$request->name;
            $image_src = asset('/').$request->editableImagesPath.'/'.$request->name.$rand_val;
        }
      
      
        $img = Image::make($imagePath);
        $img->rotate(90);

        if($img->save($imagePath)){
         return response()->json([ 'status'=> true ,'image_src' => $image_src ,'image_id' => $request->id ]);
        }else{
         return response()->json([ 'status'=> false ,'message' => 'somthig went wromg' ]);
        }

    }

    public function fetchDocuments(Request $request){

        $session_id = Session::getId();
        $uploadPath = $request->uploadPath;
        $data = DB::table($request->tempTable)->where('session_id',$session_id)->orderBy('created_at','DESC')->first();

        $card =   view('components.dash.view.dropzone-image',['data'=> $data,'uploadPath' => $uploadPath ,'tempTableImageFieldName' => $request->tempTableImageFieldName ,
            'tableImageFiledName' => $request->tableImageFiledName ,'formFieldName' => 
            $request->formFieldName])->render();

        $slider_div =  view('components.dash.view.dropzone-image-slider',['data'=> $data,'uploadPath' => $uploadPath ,'tempTableImageFieldName' => $request->tempTableImageFieldName ,
        'tableImageFiledName' => $request->tableImageFiledName ,'formFieldName' => 
        $request->formFieldName])->render();

        return response()->json([ 'status'=> true ,'card' => $card ,'slider_div' => $slider_div ]);
 

    }
   
}
