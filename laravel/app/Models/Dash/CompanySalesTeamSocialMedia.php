<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySalesTeamSocialMedia extends Model
{
    use HasFactory;
    protected $table = 'company_sales_team_social_media';

    protected $fillable = ['company_user_id','company_sales_team_id', 'social_media_id', 'value'];

}
