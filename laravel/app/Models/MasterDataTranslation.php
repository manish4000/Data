<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDataTranslation extends Model
{
    use HasFactory;
    
    protected $table = 'master_data_translations';

    protected $fillable = ['value','language_data','db_models'];
    protected $casts = [
        'language_data' => 'json',
        'db_models' => 'json'
    ];
    
    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('value', 'like', '%'.$keyword.'%');
        });
    }


    // public static function boot() {
  
    //     parent::boot();
        
    //     static::updated(function($model) {  

           
    //         /*
    //             Write Logic Here
    //         */    
    //         foreach ($model->db_models as $modelName) {

    //             $modelClass = new $modelName;
    //             $modelObject =   $modelClass->where('name',$model->value)->first();
    //             $modelObject->update(['title_languages' => $model->language_data]);
    //         } 
    //     });

    // }

    protected static function booted()
    {   
        static::updated(function($model){ 
            foreach ($model->db_models as $modelName) {

                $modelClass = new $modelName;
                $modelObject =   $modelClass->where('name',$model->value)->first();

                $modelObject->where('id', $modelObject->id)->update(['title_languages' => $model->language_data]);
            } 
        });
        
    }




}
