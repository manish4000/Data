<?php

namespace App\Models\Dash\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class HsCode extends Model
{
    use HasFactory,SoftDeletes,MasterDataTrait;

    protected $connection = 'dash';
    protected $table = 'hs_code';
    protected $primaryKey = 'id';

    protected $fillable = ['name','title_languages','fuel','type','engine_cc','year', 'carrying_capacity_kg','gross_weight_kg','admin_memo'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function parent() {
        return $this->belongsToOne(__CLASS__, 'parent_id', 'id');
    }
   
    public function children() {
        return $this->hasMany(__CLASS__, 'parent_id')->orderBy('name', 'asc');
    }
 
    public function scopeParentOnlyFilter($query)
    {   
        return $query->where( 'parent_id',null)->orWhere('parent_id', 0);
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')->orWhereHas( 'children', function($query) use ($keyword) {
                    $query->where('name', 'like', '%'.$keyword.'%');
            } );
        });
    }
}