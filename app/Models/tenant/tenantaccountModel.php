<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class tenantaccountModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tenants'; // Define the table name

    protected $primaryKey = 'tenant_id'; // Correctly define the primary key

    public $timestamps = true; // Enable timestamps (created_at, updated_at)

    protected $fillable = [
        'tenant_id', 
        'firstname',
        'lastname',
        'password_hash',
        'email',
        'phonenumber',
        'gender',
        'city',
        'province',
        'region',
        'postalcode',
        'currentaddress',
        'profile_pic_url',
    ];


    // If you want to use this model for authentication
    // Make sure you extend Authenticatable instead of Model
}


