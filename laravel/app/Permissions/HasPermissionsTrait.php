<?php
namespace App\Permissions;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {
      $permissions = $this->getAllPermissions($permissions);
      dd($permissions);
      if($permissions === null) {
        return $this;
      }
      $this->permissions()->saveMany($permissions);
      return $this;
    }

    public function withdrawPermissionsTo( ... $permissions ) {

      $permissions = $this->getAllPermissions($permissions);
      $this->permissions()->detach($permissions);
      return $this;

    }

    public function refreshPermissions( ... $permissions ) {

      $this->permissions()->detach();
      return $this->givePermissionsTo($permissions);
    }

    public function hasPermissionTo($permission) {

  
      return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission) {

      foreach ($permission->roles as $role){
        if($this->roles->contains($role)) {
          return true;
        }
      }
      return false;
    }

    public function hasRole( ... $roles ) {

      foreach ($roles as $role) {
        if ($this->roles->contains('slug', $role)) {
          return true;
        }
      }
      return false;
    }

    public function roles() {

      return $this->belongsToMany(Role::class,'user_roles');

    }
    public function permissions() {
      return $this->belongsToMany(Menu::class,'user_permissions','user_id','menu_id');

    }
    protected function hasPermission($permission) {

      return (bool) $this->permissions->where('permission_slug', $permission->permission_slug)->count();
    }

    protected function getAllPermissions(array $permissions) {

      return Menu::whereIn('permission_slug',$permissions)->get();
      
    }

}