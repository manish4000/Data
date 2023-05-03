<?php

namespace App\Models\Dash;

use App\Models\Ports;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = ['status','title','name','company_name','customer_uid','password','email_1','email_2','mobile_1','mobile_2','address','city','state','country','port','zip_code','religion','nationality','birth_date','anniversary_date','facebook','instagram','twitter','linked_in','sales_person','rating','stage','term','broker','next_follow_up_date','opening_balance','opening_balance_date','opening_balance_type','currency','visiting_card_img','admin_memo','registration_date','registered_by','registered_ip','registered_by_user_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',  
    ];

    public function city(){
        return $this->belongsTo(CityModel::class,'city','id');
    }

    public function state(){
        return $this->belongsTo(StateModel::class,'state','id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country','id');
    }
    
    public function ports(){
        return $this->belongsTo(Ports::class,'port','id');
    }

    public function religion(){
        return $this->belongsTo(Religion::class,'religion','id');
    }


    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
               $query->where('name', 'like', '%'.$keyword.'%')
               ->orWhere('email_1' ,'like','%'.$keyword.'%');
        });
    }

    public function scopeStatusFilter($query,$status){
        return $query->where( function($query) use ($status) {
            $query->where('status', $status);
        });
    }
}