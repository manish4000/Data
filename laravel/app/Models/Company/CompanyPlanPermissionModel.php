<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPlanPermissionModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'company_plan_permissions';
    protected $fillable = ['company_plan_id','permissions'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'permissions' =>'json'
    ];
}
