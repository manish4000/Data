<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TestmonialImagesModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'company_testimonial_images';
        protected $connection = 'dash';

}
