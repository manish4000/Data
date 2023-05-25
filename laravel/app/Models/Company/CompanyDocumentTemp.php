<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocumentTemp extends Model
{
    use HasFactory;
    protected $table = 'company_documents_temp';
    protected $connection = 'dash';
    protected $fillable = ['file_name','document_name'];
}