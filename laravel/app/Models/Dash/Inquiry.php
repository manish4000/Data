<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'inquiry';
    protected $cast = [
        'messenger' => 'json',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];
    protected $fillable = [
            'company_id', 'stock_number', 'type', 'subtype', 'make', 'model', 'model_code', 'chassis_no', 'fuel_id', 'fuel','transmission_id', 'transmission', 'year_from','year_to', 'mileage', 'terms_id', 'terms', 'budget', 'currency_id','currency','customer_message','name', 'email', 'country', 'country_id', 'port', 'port_id', 'purchase_capacity', 'customer_type', 'phone', 'messenger', 'next_contact_date', 'admin_memo', 'rating_id', 'rating',  'source_id', 'source', 'stage_id', 'stage', 'sales_person_id', 'sales_person', 'inquiry_date', 'dealer_comment','created_at', 'updated_at'
    ];

    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
               $query->where('name', 'like', '%'.$keyword.'%')
               ->orWhere('email' ,'like','%'.$keyword.'%')
               ->orWhere('make' ,'like','%'.$keyword.'%')
               ->orWhere('model' ,'like','%'.$keyword.'%')
               ->orWhere('model_code' ,'like','%'.$keyword.'%');
        });
    }
}
