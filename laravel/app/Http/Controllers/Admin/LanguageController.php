<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteLanguage;

class LanguageController extends Controller
{
    
    public function swap($locale) {
        $availLocale = SiteLanguage::get(['alias'])->pluck('alias')->toArray();
        if(in_array($locale, $availLocale))  session()->put('locale',$locale);
        return redirect()->back();
    }

}