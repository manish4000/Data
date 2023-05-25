<?php

namespace App\Models\Company;

use App\Models\Dash\CompanyRole;
use App\Models\Dash\CompanyUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPermission extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'company_permissions';
      

   public function roles() {
      return $this->belongsToMany(CompanyRole::class,'company_role_permissions');
   } 


   public function child(){
      return $this->hasMany(static::class, 'parent_id');
   }

   public function companyUsers() {
      return $this->belongsToMany(CompanyUsers::class,'company_user_permissions','company_permission_id','company_user_id');
   }
  
   public function parent(){
      return $this->belongsTo(static::class, 'parent_id');
   }

}
