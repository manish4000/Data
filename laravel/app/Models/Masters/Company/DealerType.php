<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'dealer_types';
    protected $connection = 'dash';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'display'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
}
