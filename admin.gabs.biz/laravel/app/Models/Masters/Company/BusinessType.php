<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'business_types';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'display', 'is_service', 'jct_ref_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
}
