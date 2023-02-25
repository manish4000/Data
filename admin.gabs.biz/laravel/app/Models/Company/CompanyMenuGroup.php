<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMenuGroup extends Model
{
    use HasFactory;
    protected $table = "company_menu_groups";


    public function menu() {
        return $this->hasMany(CompanyMenuGroupMenu::class, 'company_menu_group_id');
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
    }
}
