<?php

namespace App\Models\tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtpModels extends Model
{
      
    use HasFactory, SoftDeletes;

    protected $table = 'otp'; 
    protected $primaryKey = 'otp_id'; 
    public $timestamps = true; 
    protected $fillable = [
        'tenant_id',
        'email',
        'otpCode',
        'otpExpires_at',

    ];
        protected $dates = ['otpExpires_at', 'deleted_at'];



}
