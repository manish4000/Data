<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyContactPersonDetails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'company_contact_person_details';
    
}
