<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentPermission extends Model
{
    use HasFactory;
    protected $table = 'department_permission';
    protected $fillable = ['department_id', 'menu_id'];


    

}
