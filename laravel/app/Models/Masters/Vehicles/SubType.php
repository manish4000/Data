<?php

namespace App\Models\Masters\Vehicles;

//App\Models\Masters\Vehicles\Type

use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubType extends Model
{

    use HasFactory, SoftDeletes,MasterDataTrait;
    protected $table = 'subtype';
    protected $primaryKey = 'id';
   
    protected $fillable = ['name', 'display','title_languages','parent_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function parent() {
        return $this->belongsToOne(__CLASS__, 'parent_id', 'id');
    }

    public function type() {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }


  //each category might have multiple children
    public function children() {
        return $this->hasMany(__CLASS__, 'parent_id')->orderBy('name', 'asc');
    }

    public function scopeParentOnlyFilter($query)
    {
        return $query->where( function($query) {
            $query->where('parent_id', null)->orWhere('parent_id', 0);
        });
    }

    public function scopeParentIdFilter($query, $parent_id)
    {
        return $query->where('parent_id', $parent_id);
    }

    public function scopeDisplayStatusFilter($query, $displayStatus)
    {
        return $query->where( 'display', $displayStatus);
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhereHas( 'children', function($query) use ($keyword) {
                    $query->where('name', 'like', '%'.$keyword.'%');
            } );
        });
    }

    public function scopeTypeFilter($query, $type_id)
    {   
        return $query->where( function($query) use ($type_id) {
            $query->where('type_id', $type_id)
            ->orWhereHas( 'children', function($query) use ($type_id) {
                    $query->where('type_id', $type_id);
            } );
        });
        
    }
    



}
