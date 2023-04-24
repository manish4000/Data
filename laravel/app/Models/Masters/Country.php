<?php

namespace App\Models\Masters;

use App\Models\Region;
use App\Models\RegionModel;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes,MasterDataTrait;
    protected $table = 'countries';
    protected $primaryKey = 'id';

    protected $fillable = ['regions_id','currency_symbol','title_languages','region','name', 'display', 'phone_code', 'country_code', 'as_from', 'currency', 'jct_ref_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function parent() {
        return $this->belongsTo(static::class, 'parent_id', 'id')->select(['id', 'name']);
    }
    // public function region() {
    //     return $this->belongsTo('App\Models\Masters\Regions', 'regions_id', 'id')->select(['id', 'name']);
    // }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('phone_code','like', '%'.$keyword.'%')
            ->orWhere('country_code','like', '%'.$keyword.'%')
            ->orWhere('region','like', '%'.$keyword.'%');
        });
    }

    public function regionData() {
        return $this->belongsTo(Region::class, 'regions_id');
    }
}
