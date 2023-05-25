<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealIns extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'dash';
    protected $table = 'deal_ins';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'display', 'parent_id', 'jct_ref_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
    public function parent() {
        return $this->belongsTo('App\Models\Masters\DealIns', 'parent_id', 'id')->select(['id', 'name']);
    }

    public function children() {
        return $this->hasMany(__CLASS__, 'parent_id')->orderBy('name', 'asc');
    }


    public function scopeParentOnlyFilter($query)
    {
        return $query->where( function($query) {
            $query->where('parent_id', null)->orWhere('parent_id', 0);
        }  );
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
}
