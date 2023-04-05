<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masters\Vehicles\Make;
use App\Models\Masters\Vehicles\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataImportController extends Controller
{
    public function importData(){

        $old_data = DB::table('types_old')->where('inserted','0')->take(300)->get();

        foreach($old_data as $key => $value){

            if(!Type::where('name',$value->name)->exists()){

                $company_user_data = [
                    'name' => $value->name, 
                    'parent_id' => $value->parent_id, 
                    'display' => $value->display,
                    'created_at' => isset($value->created_at)?$value->created_at : \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => isset($value->updated_at)?$value->updated_at : \Carbon\Carbon::now()->toDateTimeString(),
                    'deleted_at' => isset($value->deleted_at)?$value->deleted_at : \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                   
                if(!(Type::create($company_user_data))){ 
                    break;
                }else{
                    DB::table('types_old')->where('id',$value->id)->update(['inserted' => '1']);
                }
            }
        }
    }
}
