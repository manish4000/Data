<?php

namespace App\Models\Dash;

use App\Models\Company\CompanyPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyRole extends Model
{
    use HasFactory,SoftDeletes;
    protected $connection = 'dash';
    protected $fillable = ['name'];
    
    public function setNameAttribute($value)
    {
       $this->attributes['name'] = $value;
       $this->attributes['slug'] = Str::slug($value);
    }

    public function permissions() {
        return $this->belongsToMany(CompanyPermission::class,'company_role_permissions','company_role_id','company_menu_id');
    }
 
    public function users() {
        return $this->belongsToMany(CompanyUsers::class,'company_user_roles');
    }


}
