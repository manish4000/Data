<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Permissions\RoleHasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
   use HasFactory, RoleHasPermissionsTrait, SoftDeletes;
   protected $fillable = ['name'];

   public function setNameAttribute($value)
   {
      $this->attributes['name'] = $value;
      $this->attributes['slug'] = Str::slug($value);
   }

   //  public function permissions() {
   //     return $this->belongsToMany(Permission::class,'role_permissions');
   //  }
    public function permissions() {
       return $this->belongsToMany(Permission::class,'role_permissions','role_id','menu_id');
    }

    public function users() {
       return $this->belongsToMany(User::class,'user_roles');
    }
}
