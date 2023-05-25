<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRolePermission extends Model
{
    use HasFactory;
    protected $table = 'company_role_permissions';
    protected $connection = 'dash';
}
