<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateCityController extends Controller
{
    public  function stateList(Request $request){

        $states  =   DB::table('states')->where('country_id',$request->id)->get();
        return response()->json(['states' => $states]);
    }

    public  function cityList(Request $request){

        $cities  =   DB::table('cities')->where('state_id',$request->id)->get();

        return response()->json(['cities' => $cities]);

    }
}
