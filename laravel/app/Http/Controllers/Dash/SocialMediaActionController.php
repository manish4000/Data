<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialMediaActionController extends Controller
{
    public function socialMedia(Request $request){
        $socialMedia  =   DB::connection('dash')->table('social_medias')->select('id as value', 'name')->where('deleted_at',NULL)->get();
        
     
        return view('dash.content.users.social_media_action',['id' => $request->id,'social_media' => $socialMedia]);
    }
}
