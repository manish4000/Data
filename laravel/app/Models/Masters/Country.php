<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'countries';
    protected $primaryKey = 'id';

    protected $fillable = ['regions_id', 'name', 'display', 'phone_code', 'country_code', 'as_from', 'currency', 'jct_ref_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function parent() {
        return $this->belongsTo(static::class, 'parent_id', 'id')->select(['id', 'name']);
    }
    // public function region() {
    //     return $this->belongsTo('App\Models\Masters\Regions', 'regions_id', 'id')->select(['id', 'name']);
    // }
}
