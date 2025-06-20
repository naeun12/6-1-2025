<?php

namespace App\Http\Controllers\tenant\auth;
use App\Models\landlord\landlordAccountModel;
use App\Models\landlord\landlordRoomModel;
use App\Models\landlord\landlordDormManagement; 
use App\Models\tenant\tenantaccountModel; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class dormitories extends Controller
{
    public function dormitoriesListing($tenant_id)
    {
        $sessionTenant_id = session('tenant_id');
    
        if (!$sessionTenant_id) {
            return redirect()->route('tenant-login')->with('error', 'Please log in as a landlord.');
        }
    
        if ($tenant_id !== $sessionTenant_id) {
            return redirect()->route('tenant-login')->with('error', 'Unauthorized access.');
        }
    
        $tenant = tenantaccountModel::find($tenant_id);
        if (!$tenant) {
            return redirect()->route('tenant-login')->with('error', 'Landlord not found.');
        }
        return view('tenant.auth.dormitories',['title' => 'Dormitories  - Dormhub',
        'tenant_id',$tenant,'cssPath' => asset('css/tenantpage/auth/dormitorymap.css')]);

    }
    public function Listdorms()
    {
        $dorms = landlordDormManagement::with(['amenities','images'])->get();
        return response()->Json([
            'status' => 'success',
            'dorms' => $dorms,
        ]);
    }
    public function ViewDoorms()
    {
        
    }
}
