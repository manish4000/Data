<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'organization_types';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'display'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function parent() {
        return $this->belongsTo('App\Models\Masters\OrganizationTypes', 'organization_types_id', 'id')->select(['id', 'name']);
    }
}
