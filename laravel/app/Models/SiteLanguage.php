<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteLanguage extends Model
{
    use HasFactory;
    protected $fillable = ['language_en', 'language_text', 'status','alias','show_in_captions','show_in_masters','default_lang'];   

    public function scopeActiveSiteLanguagesForMaster(){
        return $this->where('status', 'Active')->where('show_in_masters',1)->get();
    }
    public function scopeActiveSiteLanguagesForCaption(){
        return $this->where('status', 'Active')->where('show_in_captions',1)->get();
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('language_en', 'like', '%'.$keyword.'%');
        });
    }

    public function scopeStatusFilter($query, $status)
    {   
        return $query->where('status', $status);
    }

    public function  scopeShowMasterFilter($query, $status){
        return $query->where('show_in_masters', $status);
    }
    
    public function  scopeShowCaptionFilter($query, $status){
        return $query->where('show_in_captions', $status);
    }

}
