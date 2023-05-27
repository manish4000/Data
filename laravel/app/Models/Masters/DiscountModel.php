<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountModel extends Model
{
    use HasFactory,SoftDeletes,MasterDataTrait;

    protected $table = 'discounts';

    protected $primaryKey = 'id';

    protected $fillable = ['name','title_languages','display', 'currency_id','amount'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function scopeDisplayStatusFilter($query, $displayStatus)
    {
        return $query->where( 'display', $displayStatus);
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')->orwhere('amount','like','%'.$keyword.'%');
        });
    }
}
