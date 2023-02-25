<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;

    protected $table = "menu_groups";

    protected $casts = [
        'title_languages' => 'json'
    ];

    public function menu() {
        return $this->hasMany(Menu::class, 'menu_group_id');
    }

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
    }


}
