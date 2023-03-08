<?php

namespace App\Models\Dash;

use App\Models\Masters\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTestimonial extends Model
{
    use HasFactory;
    protected $table = 'company_testimonial';
    
    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

}
