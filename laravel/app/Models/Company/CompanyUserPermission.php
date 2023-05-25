<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUserPermission extends Model
{
    use HasFactory,SoftDeletes;
    protected $connection = 'dash';
    protected $table = 'company_user_permissions';
    protected $fillable = ['company_user_id', 'company_menu_id'];
    
}
