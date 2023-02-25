<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerShipType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ownership_types';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'display', 'jct_ref_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
}
