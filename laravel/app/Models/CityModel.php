<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    use HasFactory;
    protected $table = "cities";
    protected $fillable = ['title_languages','name', 'state_id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function state(){
        return $this->belongsTo(StateModel::class, 'state_id','id');
    }

    public function scopeKeywordFilter($query, $keyword)
    {   
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%');
        });
    }

    
    public function scopeStateFilter($query,$state_id){
        return $query->where( function($query) use ($state_id) {
            $query->where('state_id', $state_id );
        });
    }

}
