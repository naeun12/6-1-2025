<?php

namespace App\Models\landlord;

use Illuminate\Database\Eloquent\Model;

class tenantscreeningModel extends Model
{
    protected $table = 'tenant_screening';
    protected $primaryKey = 'tenantscreening_id';
    public $timestamps = true;

    protected $fillable = [
        'fkdormitory_id',
        'fkroom_id',
        'fktenant_id',
        'firstname',
        'lastname',
        'contact_number',
        'contact_email',
        'age',
        'gender',
        'status',
        'studentpicture_id',
        'payment_type',
        'payment_image',
        'created_at',
        
    ];
}
