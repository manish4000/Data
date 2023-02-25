<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\isNull;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('email' ,'like','%'.$keyword.'%');
              
        });
    }

    public function permissions()
    {   
        return $this->belongsToMany(Menu::class, 'user_permissions','user_id','menu_id');
    }

    // public function staffs() {
    //     return $this->hasOne('App\Models\Staffs', 'ref_id', 'id')->select();
    // }
    
    // public function company() {
    //     return $this->hasOne('App\Models\Companies', 'ref_id', 'id')->select();
    // }

    // public function checkPermissions($permissions = null) {
    //     //add this for test  
      
    //     //this is for super admin to bypass the permissions
    //     $userRoles = $this->roles()->pluck('id')->toArray();
    //     if( in_array(1, $userRoles) ) {
    //         return TRUE;
    //     }
      
    //     if(  $permissions != null && is_array($permissions) ) {
    //         return ($this->permissions()->whereIn('permission_id', $permissions)->count() >  0)?TRUE:FALSE;
    //     }
    //     return true;
    // }

    //this is for testing for check  permission with menu 

    public function checkPermissions($permissions = null) {

        //this is for super admin to bypass the permissions
        // $userRoles = $this->roles()->pluck('id')->toArray();
        // if( in_array(1, $userRoles) ) {
        //     return TRUE;
        // }
      
        if(  $permissions != null  ) {

            // print_r($permissions);
          return   ($this->permissions()->where('menu_id', $permissions)->count() > 0) ? TRUE :FALSE;
          
            // dd($this->permissions()->whereIn('permission_id', $permissions)->get());
        }
        return true;
    }
}
