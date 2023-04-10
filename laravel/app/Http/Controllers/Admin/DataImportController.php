<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masters\Country;
use App\Models\Masters\Vehicles\Make;
use App\Models\Masters\Vehicles\Type;
use App\Models\RegionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataImportController extends Controller
{
    public function importData(){

        $old_data = DB::table('countries_old')->where('inserted','0')->take(100)->get();

        foreach($old_data as $key => $value){

            if(!Country::where('name',$value->name)->exists()){

                $company_user_data = [
                    'id' => $value->id,
                    'name' => $value->name, 
                    'phone_code' => $value->phone_code, 
                    'country_code' => $value->country_code, 
                    'currency' => $value->currency, 
                    'currency_symbol' => $value->currency_symbol, 
                    'regions_id' => $value->regions_id, 
                    'region' => $value->region, 
                    'as_from' => $value->as_from, 
                    'jct_ref_id' => $value->jct_ref_id, 
                    'parent_id' => $value->parent_id, 
                    'display' => $value->display,
                    'created_at' => isset($value->created_at)?$value->created_at : \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => isset($value->updated_at)?$value->updated_at : \Carbon\Carbon::now()->toDateTimeString(),
                    'deleted_at' => isset($value->deleted_at)?$value->deleted_at : \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                   
                if(!(Country::create($company_user_data))){ 
                    break;
                }else{
                    DB::table('countries_old')->where('id',$value->id)->update(['inserted' => '1']);
                }
            }
        }
    }
}
