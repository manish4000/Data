<?php

namespace App\Models\Dash\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'payments';
    protected $connection = 'dash';
    protected $primaryKey = 'id';
    protected $fillable = ['cash_in_date','payment_status','payment_ref_no','receiving_bank','amount','currency','ex_rate','accounting_currency','balance_amount','refund_amount','refund_date','client_id','customer_name','depositer_name','payment_mode','memo','note_for_accounting','payment_receipt', 'paymentMode'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',  
    ];

    public function currency(){
        return $this->belongsTo(Currency::class,'currency','id');
    }

    public function paymentMode(){
        return $this->belongsTo(paymentMode::class,'payment_mode','id');
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