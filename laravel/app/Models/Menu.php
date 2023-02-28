<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu';

    protected $casts = [
        'permissions' => 'json',
        'title_languages' => 'json'
    ];

    public function child(){
        return $this->hasMany(static::class, 'parent_id')->where('type','menu');
    }

    public function menuChild(){
        return $this->hasMany(static::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(static::class, 'parent_id');
    }

    //this is for testing purpose only
    public function users() {
        return $this->belongsToMany(User::class,'user_permissions');
     }

     public function roles() {
        return $this->belongsToMany(Role::class,'role_permissions');
     }
}   
