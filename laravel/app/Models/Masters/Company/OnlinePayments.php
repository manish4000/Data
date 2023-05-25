<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MasterDataTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayments extends Model
{
    use HasFactory,SoftDeletes,MasterDataTrait;

    protected $connection = 'dash';
    protected $table = 'online_payments';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'logo' ,'commission', 'description','title_languages'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'title_languages' => 'json'
    ];

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%');
            } );
        }

        public function scopeDisplayStatusFilter($query, $displayStatus)
    {
        return $query->where( 'display', $displayStatus);
    }
    
}