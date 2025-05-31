<?php

namespace App\Models\landlord;

use Illuminate\Database\Eloquent\Model;

class landlordAmintiesModel extends Model
{
    public $table = 'amenities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',    
        'created_at',
        'updated_at'
    ];
    public function dorms()
    {
        return $this->belongsToMany(Dorm::class, 'dorm_amenity');
    }
    public function dormAmenities()
{
    return $this->hasMany(landlordDormAnimitiesModel::class, 'amenity_id');
}
    
}
