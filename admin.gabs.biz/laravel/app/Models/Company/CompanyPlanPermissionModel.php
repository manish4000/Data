<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlanPermissionModel extends Model
{
    use HasFactory;
    protected $table = 'company_plan_permissions';
    protected $fillable = ['company_plan_id','permissions'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'permissions' =>'json'
    ];
}
