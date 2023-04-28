<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
   
}
