<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashTempImagesModel extends Model
{
    use HasFactory;
    protected $connection = 'dash';
    protected $table = 'dash_images_temp';
}
