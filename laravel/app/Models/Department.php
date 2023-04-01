<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'departments';

    public function scopeKeywordFilter($query, $keyword)
    {   
     
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('slug','like', '%'.$keyword.'%');
        });
    }

    public function permissions()
    {   
        return $this->belongsToMany(Menu::class, 'department_permission','department_id','menu_id');
    }


}
