<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'organizations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'abbreviation_name',
        'organization_type_id',
        'logo',
        'description',
        'jct_page_url_prefix',
        'jct_page_url',
        'website_prefix',
        'website',
        'person_name',
        'email',
        'jct_ref_id',
        'send_enquiry',
        'display'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
    public function organizationtypes() {
        return $this->belongsTo('App\Models\Masters\OrganizationTypes', 'organization_type_id', 'id')->select(['id', 'name']);
    }
}
