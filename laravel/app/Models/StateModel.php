<?php

namespace App\Models;

use App\Models\Masters\Country;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateModel extends Model
{
    use HasFactory,SoftDeletes,MasterDataTrait;
    protected $connection = 'dash';
    protected $table = "states";

    protected $fillable = ['title_languages','name', 'country_id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];
    public function country(){
        return $this->belongsTo(Country::class, 'country_id','id');
    }

    public function scopeKeywordFilter($query, $keyword)
    {   
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%');
        });
    }

    public function scopeCountryFilter($query,$country_id){
        return $query->where( function($query) use ($country_id) {
            $query->where('country_id', $country_id );
        });
    }

}
