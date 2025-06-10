<?php

namespace App\Http\Controllers\landloard\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class tenantScreeningController extends Controller
{
    public function tenantScreening()
    {
        return view('landlord.auth.tenantScreening',["title" => "Landlord - Tenants", 'headerName' => 'Tenants Screening']);
        
    }
}
