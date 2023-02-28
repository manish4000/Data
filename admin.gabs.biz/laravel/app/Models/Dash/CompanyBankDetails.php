<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBankDetails extends Model
{
    use HasFactory;

    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
               $query->where('bank_name', 'like', '%'.$keyword.'%')
               ->orWhere('branch_name' ,'like','%'.$keyword.'%')
               ->orWhere('dealer_name' ,'like','%'.$keyword.'%')
               ->orWhere('branch_code' ,'like','%'.$keyword.'%')
               ->orWhere('account_name' ,'like','%'.$keyword.'%')
               ->orWhere('account_number' ,'like','%'.$keyword.'%')
               ->orWhere('swift_code' ,'like','%'.$keyword.'%');
        });
    }
}
