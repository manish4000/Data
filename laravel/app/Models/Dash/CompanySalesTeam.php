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
        'personal_messenger' => 'json',
        'company_messenger' => 'json',
        'company_social_media' => 'json',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];
    protected $fillable = [
        'company_id', 'company_user_id', 'title', 'name', 'email', 'password', 'status', 'image', 'verification','department_id', 'department', 'designation_id','designation', 'roles_id', 'roles', 'admin_memo', 'company_address', 'company_country_id','company_country','company_state_id','company_state', 'company_city_id', 'company_city', 'company_zip_code', 'company_messenger', 'company_messenger_name', 'company_phone', 'current_address', 'current_country_id', 'current_country', 'current_state_id', 'current_state', 'current_city_id', 'current_city',  'current_zip_code', 'same_as_current', 'permanent_address', 'permanent_country_id', 'permanent_country', 'permanent_state_id', 'permanent_state', 'permanent_city_id', 'permanent_city', 'permanent_zip_code', 'personal_phone', 'personal_messenger', 'personal_messenger_name', 'language_id','language_name', 'religion','religion_id', 'anniversary_date', 'dob', 'company_social_media', 'created_at', 'updated_at'
    ];

    public function salesSocialMedia(){
        return $this->hasMany(CompanySalesTeamSocialMedia::class,'company_sales_team_id','id');
    }

}
