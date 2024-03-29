<?php

namespace App\Models\Dash;

use App\Models\Masters\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class CompanyTestimonial extends Model
{
    use HasFactory;
    protected $connection = 'dash';
    protected $table = 'company_testimonial';
    
    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('email' ,'like','%'.$keyword.'%')
            ->orWhere('person_name' ,'like','%'.$keyword.'%');
        });
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    
    public function images(){
        return $this->hasMany(TestmonialImagesModel::class,'company_testimonial_id');
    }

}
