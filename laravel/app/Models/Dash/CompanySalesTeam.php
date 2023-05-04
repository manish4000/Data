<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySalesTeam extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'company_sales_team';
    protected $cast = [
        'language_id' => 'json',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];
    protected $fillable = [
        'company_id', 'company_user_id', 'name', 'email', 'password', 'status', 'image', 'two_step_verification','department_id', 'department', 'designation_id','designation', 'two_step_verfication', 'local_address', 'local_country_id','local_country','local_state_id','local_state', 'local_city_id', 'local_city', 'local_zip_code', 'same_as_local', 'permanent_address', 'permanent_country_id', 'permanent_country', 'permanent_state_id', 'permanent_state', 'permanent_city_id', 'permanent_city', 'permanent_zip_code', 'phone_1', 'phone_2', 'skype', 'language_id','language_name', 'religion','religion_id', 'anniversary_date', 'dob', 'gender', 'created_at', 'updated_at'
    ];

    public function salesSocialMedia(){
        return $this->hasMany(CompanySalesTeamSocialMedia::class,'company_sales_team_id','id');
    }

}
