<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\SiteLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function swap($locale) {

        $availLocale = SiteLanguage::get(['alias'])->pluck('alias')->toArray();
      
        if(in_array($locale, $availLocale))  session()->put('locale',$locale);

        return redirect()->back();
    }
}
