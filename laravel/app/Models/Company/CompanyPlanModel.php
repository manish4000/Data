<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CompanyPlanModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'company_plans';

    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('slug','like', '%'.$keyword.'%');
        });
    }

}
