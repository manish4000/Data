<?php

namespace App\Models\Company;

use App\Models\Dash\CompanyRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyMenuGroupMenu extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'company_menu_groups_menu';

  
    protected $casts = [
        'permissions' => 'json'
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

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
    }

    public function roles() {
        return $this->belongsToMany(CompanyRole::class,'company_role_permissions','company_menu_id','company_role_id');
    }
}
