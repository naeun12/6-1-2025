<?php

namespace App\Models\landlord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class landlordDormManagement extends Model
{
    use  HasFactory, Notifiable;  // Add HasApiTokens here
    protected $table = 'dorms';
    protected $primaryKey = 'dorm_id';
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        'dorm_id',
        'dorm_name',
        'landlord_id',
        'address',
        'latitude',
        'longitude',
        'description',
        'amenities',
        'total_rooms',
        'available_rooms',
        'contact_email',
        'contact_phone',
        'rules',
        'created_at',
        
    ];
    public function amenities()
{
    return $this->belongsToMany(
        \App\Models\landlord\landlordAmintiesModel::class,
        'amenity_dorm',
        'dorm_id',
        'amenity_id',
        
    )->withPivot('id');;
    
}

}






