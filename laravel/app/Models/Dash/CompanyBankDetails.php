<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;

class CompanyBankDetails extends Model implements CipherSweetEncrypted
{
    use HasFactory,UsesCipherSweet;
    protected $connection = 'dash';

    public function scopeKeywordFilter($query, $keyword){
        return $query->where( function($query) use ($keyword) {
            $query->where('bank_name', 'like', '%'.$keyword.'%')
               ->orWhere('branch_name' ,'like','%'.$keyword.'%')
            //    ->orWhere('dealer_name' ,'like','%'.$keyword.'%')
               ->orWhere('branch_code' ,'like','%'.$keyword.'%')
               ->orWhere('account_name' ,'like','%'.$keyword.'%')
               ->orWhere('swift_code' ,'like','%'.$keyword.'%');
        });
    }

    public function scopeAccountNumberFilter($query, $account_number){
        return   $query->whereBlind('account_number','account_number_index', $account_number);
    }

//    //encrypt the string
//    public function setAccountNumberAttribute($value)
//    {
//        $this->attributes['account_number'] = Crypt::encryptString( $value);
//    }
//
//
//    //dcrypt the string
//
//    public function getAccountNumberAttribute($value)
//    {
//
//            return  Crypt::decryptString($value);
//    }

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField('account_number')
            ->addBlindIndex('account_number', new BlindIndex('account_number_index'));
    }
}
