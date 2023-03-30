<?php

namespace App\Models\Masters\Company;

use App\Models\Company\CompanyContactPersonDetails;
use App\Models\Company\CompanyDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $cast = [
        'language_id' => 'json',
        'organization_id' => 'json',
        'payment_term_id' => 'json',
        'deals_in_id' => 'json',
        'business_type_id' => 'json',
        'service_id' => 'json',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    protected $fillable = [
        'name', 'dealer_type_id', 'short_name', 'status', 'membership_type_id', 'address', 'postcode',
        'city_id', 'state_id', 'country_id','language_id', 'organization_id', 'website_prefix', 'website', 'ownership_type_id', 'payment_term_id', 'year_established', 'number_of_staffs', 'office_timing', 'holidays', 'deals_in_id', 'business_type_id',
        'dealer_permit_number', 'display', 'service_id', 'jct_ref_id'
    ];


    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')->orWhere( 'company_name', 'like', '%'.$keyword.'%')->orWhere('email','like','%'.$keyword.'%');
        });
    }
    
    public function scopeCountryFilter($query, $country)
    {
        return $query->where( function($query) use ($country) {
            $query->where('country_id', $country);
        });
    }
    public function scopeStatusFilter($query, $status)
    {
        return $query->where( function($query) use ($status) {
            $query->where('status', $status);
        });
    }

    public function file() {
        return $this->hasOne(CompanyFile::class, 'company_id');
    }

    public function social_profile() {
        return $this->hasOne(CompanySocialProfile::class, 'company_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function contcatPersonDetails(){
        return $this->hasMany(CompanyContactPersonDetails::class,'company_id');
    }


    public function documents(){
        return $this->hasMany(CompanyDocument::class,'company_id');
    }

}
