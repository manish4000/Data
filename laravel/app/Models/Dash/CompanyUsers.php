<?php

namespace App\Models\Dash;

use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyPermission;
use App\Models\CompanyGabsModel;
use App\Models\Masters\Company\Company;
use App\Permissions\HasDashPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUsers extends Authenticatable
{
    use HasFactory,SoftDeletes, Notifiable,HasDashPermissionsTrait;

     /**
     * The attributes that are mass assignable.
     * @var array
     */
    
    protected $guard = 'dash';
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'status',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions()
    {
        return $this->belongsToMany(CompanyMenuGroupMenu::class, 'company_user_permissions','company_user_id','company_menu_id');
    }
    
    // public function permissions()
    // {
    //     return $this->belongsToMany(CompanyPermission::class, 'company_user_permissions','company_user_id','company_permission_id');
    // }

    // public function company() {
    //     return $this->hasOne('App\Models\Companies', 'ref_id', 'id')->select();
    // }
    public function company(){
        return $this->belongsTo(CompanyGabsModel::class,'company_id','id');
    }

    public function companySalesTeam(){
        return $this->hasOne(CompanySalesTeam::class,'company_user_id','id');
    }



    public function checkPermissions($permissions = null) {

        // dd("i am here");
        //this is for super admin to bypass the permissions
        // $userRoles = $this->roles()->pluck('id')->toArray();
        // if( in_array(1, $userRoles) ) {
        //     return TRUE;
        // }
        if($permissions != null) {
            return   ($this->permissions()->where('company_menu_id', $permissions)->count() > 0) ? TRUE :FALSE;
           // return ($this->permissions()->whereIn('company_permission_id', $permissions)->count() >  0)?TRUE:FALSE;
        }
        return true;
    }

    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
               $query->where('name', 'like', '%'.$keyword.'%')
               ->orWhere('email' ,'like','%'.$keyword.'%');
        });
    }

    public function scopeStatusFilter($query,$status){
        return $query->where( function($query) use ($status) {
            $query->where('status', $status);
        });
    }

}
