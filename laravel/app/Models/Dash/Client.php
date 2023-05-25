<?php

namespace App\Models\Dash;

use App\Models\Ports;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $connection = 'dash';
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = ['title','name','company_name','customer_uid','password','email_1','email_2','mobile_1','mobile_2','country_code_1','messenger_1','messenger_2','country_code_2','dealer_type','member_login','broker','address','city','state','country','port','zip_code','religion','nationality','birth_date','anniversary_date','social_media','sales_person','rating','stage','terms','next_follow_up_date','admin_memo','currency','opening_balance','opening_balance_date','opening_balance_type','user_iamge','visiting_card_img','company_logo','storage_days','credit_limit','bid_limitations','bid_amount_limit','bid_limit_reason','initial_payment_due_days','bid','bid_mail','sales_statistics','auction','uss','uss_images','registration_date','registered_by','registered_ip','registered_by_user_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',  
        'messenger_1' => 'json',
        'messenger_2' => 'json',
        ];

    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
               $query->where('name', 'like', '%'.$keyword.'%')
               ->orWhere('email_1' ,'like','%'.$keyword.'%');
        });
    }
}