<?php

namespace App\Models\Masters\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessories extends Model
{
    use HasFactory,SoftDeletes,MasterDataTrait;

    protected $table = 'accessories';
    protected $primaryKey = 'id';

    protected $fillable = ['name','title_languages','display', 'parent_id', 'accessories_group_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function accessoriesGroup(){
        return $this->belongsTo(AccessoriesGroup::class,'accessories_group_id','id');
    }

    public function parent() {
        return $this->belongsToOne(__CLASS__, 'parent_id', 'id');
    }

  //each category might have multiple children
    public function children() {
        return $this->hasMany(__CLASS__, 'parent_id')->orderBy('name', 'asc');
    }

    public function scopeAccessoriesGroup($query, $accessories_group){
        return $query->where('accessories_group',$accessories_group);
    }

    public function scopeParentOnlyFilter($query)
    {   
        return $query->where( 'parent_id',null)->orWhere('parent_id', 0);
    }

    public function scopeParentIdFilter($query, $parent_id)
    {
        return $query->where( 'parent_id', $parent_id);
    }

    public function scopeDisplayStatusFilter($query, $displayStatus)
    {
        return $query->where( 'display', $displayStatus);
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
