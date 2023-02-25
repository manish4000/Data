<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCaption extends Model
{
    use HasFactory;
    protected $table = 'web_captions';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'local_translations' => 'json'
    ];


    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('local_slug','like', '%'.$keyword.'%');
        });
    }

    public function scopePendingTranslation($query ,$language_ary){
        return $query->where(function($query) use ($language_ary){
            $query->whereNotIn('local_translations->title',$language_ary);
        });
        
    }


}
