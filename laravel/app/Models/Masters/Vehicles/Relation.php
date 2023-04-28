<?php

namespace App\Models\Masters\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters\Vehicles\VehicleModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'vehicle_relation';
    protected $primaryKey = 'id';

    protected $fillable = ['type_id','subtype_id','make_id', 'model_id', 'is_confirmed'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        
    ];

    public function type(){
        return $this->belongsTo(Type::class,'type_id','id');
    }

    public function subtype(){
        return $this->belongsTo(Subtype::class,'subtype_id','id');
    }

    public function make(){
        return $this->belongsTo(Make::class,'make_id','id');
    }
    
    public function vehicleModel(){
        return $this->belongsTo(VehicleModel::class,'model_id','id');
    }

    public function scopeTypeFilter($query, $type_id)
    {
        return $query->where('type_id', $type_id);
    }

    public function scopeSubTypeFilter($query, $subtype_id)
    {
        return $query->where('subtype_id', $subtype_id);
    }

    public function scopeMakeFilter($query, $make_id)
    {
        return $query->where('make_id', $make_id);
    }

    public function scopeModelFilter($query, $model_id)
    {
        return $query->where('model_id', $model_id);
    }
    


}