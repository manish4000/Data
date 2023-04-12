<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;
    protected $table = 'companies';

    protected $fillable = [
        'company_name','email','skype_id', 'address', 'postcode','city_id', 'state_id', 'country_id', 'website','email',''
    ];

}
