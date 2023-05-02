<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company\CompanyContactPersonDetails;
use App\Models\Company\CompanyDocument;
use Illuminate\Database\Eloquent\SoftDeletes;


class CompanyGabsModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'companies_gabs';
    protected $primaryKey = 'id';

    protected $cast = [
        'language_id' => 'json',
        'organization_id' => 'json',
        'payment_term_id' => 'json',
        'deals_in' => 'json',
        'business_type_id' => 'json',
        'association_member_id' => 'json',
        'service_id' => 'json',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    protected $fillable = [
        'name', 'dealer_type_id','password','gabs_uuid','association_member_id','association_member_name', 'short_name','email','marketing_status','marketing_status_name', 'status', 'membership_type_id', 'address', 'postcode','state_name','city_name','skype_id','country_name','region_name','region_id','telephone','company_name','plan_id','plan_name',
        'city_id', 'state_id', 'country_id','language_id', 'organization_id', 'website_prefix', 'website', 'ownership_type_id', 'payment_term_id', 'year_established', 'number_of_staffs', 'office_timing', 'holidays', 'deals_in_name','permit_no','deals_in', 'business_type_id','business_type',
        'dealer_permit_number', 'display', 'service_id', 'jct_ref_id'
    ];


    public function scopeKeywordFilter($query, $keyword)
    {
        return $query->where( function($query) use ($keyword) {
            $query->where( 'company_name', 'like', '%'.$keyword.'%')->orWhere('email','like','%'.$keyword.'%');
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


    public function scopeBusinessTypeFilter($query, $business_type){

        $query->whereJsonContains('business_type_id',$business_type);
    }

    public function scopePlanFilter($query, $plan)
    {
        return $query->where( function($query) use ($plan) {
            $query->where('plan_id', $plan);
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
