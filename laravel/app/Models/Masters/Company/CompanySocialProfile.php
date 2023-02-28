<?php

namespace App\Models\Masters\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySocialProfile extends Model
{
    use HasFactory, SoftDeletes;

    public function company() {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
