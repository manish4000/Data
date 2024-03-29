<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateCityController extends Controller
{

    public  function countryList(Request $request){

        $country  =   DB::connection('dash')->table('countries')->where('country_id',$request->id)->orderBy('name')->get();
        return response()->json(['countries' => $country]);
    }

    public  function stateList(Request $request){

        $states  =   DB::connection('dash')->table('states')->where('country_id',$request->id)->orderBy('name')->get();
        return response()->json(['states' => $states]);
    }

    public  function cityList(Request $request){

        $cities  =   DB::connection('dash')->table('cities')->where('state_id',$request->id)->orderBy('name')->get();

        return response()->json(['cities' => $cities]);

    }
}
