<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealIns extends Model
{
    use HasFactory, SoftDeletes;
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
}
