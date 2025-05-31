<?php

namespace App\Http\Controllers\landloard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\landlord\landlordAccountModel;
use App\Models\tenant\OtpModels;
use App\Jobs\DeleteExpiredOtpsJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\tenantEmailOtp;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class accountprocesslandlordController extends Controller
{
    public function landlordRegister()
    {
        return view('landlord.accountprocess.register', ['title' => 'Landlord - Register']);
    }
     public function landlordLogin()
    {
        return view('landlord.accountprocess.login', ['title' => 'Landlord - login']);
    }

    public function personalDetails(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|regex:/^[A-Za-z]+$/',
                'lastname' => 'required|string|regex:/^[A-Za-z]+$/',
                'email' => 'required|email|unique:landlords,email',
                'phonenumber' => 'required|string|unique:landlords,phonenumber|regex:/^\+?[0-9]{10,15}$/|size:11',
                'password' => 'required|string|min:8|confirmed',
                'profilePic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Validation passed and image uploaded successfully.'
                ], 200);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation errors occurred.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function IdentityVerifaction(Request $request)
    {
        try {
            $validated = $request->validate([
                'governmentIdPic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ], [
                'governmentIdPic.required' => 'Please upload a government ID picture.',
                'governmentIdPic.image' => 'The file must be an image.',
                'governmentIdPic.mimes' => 'Only JPG, PNG, and JPEG images are allowed.',
                'governmentIdPic.max' => 'The image may not be greater than 2MB.',
            ]);

            return response()->json([
                'status' => 'success',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function businessPermitValidation(Request $request)
    {
        try {
            $validated = $request->validate([
                'businessPermitPic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'email' => 'required|email|unique:landlords,email',
            ], [
                'businessPermitPic.required' => 'Please upload a business permit image.',
                'businessPermitPic.image' => 'The file must be an image.',
                'businessPermitPic.mimes' => 'Only JPG, PNG, and JPEG images are allowed.',
                'businessPermitPic.max' => 'The image may not be greater than 2MB.',
            ]);

            $otpCode = rand(100000, 999999);
            $expiresAt = now()->addMinutes(1);

             Mail::to($validated['email'])->send(new tenantEmailOtp($otpCode));
            OtpModels::create([
                'email' => $validated['email'],
                'otpCode' => $otpCode,
                'otpExpires_at' => $expiresAt,
                'role' => 'landlord',
            ]);
            

            $delay = $expiresAt->diffInSeconds(now());
            DeleteExpiredOtpsJob::dispatch()->delay($delay);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP has been sent to your Gmail. Please check your inbox to verify your account.',
                'timer' => $expiresAt,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function RegisterLandlord(Request $request)
    {
        try
        {
            $validated = $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:landlords,email',
                'phonenumber' => 'required|string|unique:landlords,phonenumber|regex:/^\+?[0-9]{10,15}$/|size:11',
                'password' => 'required|string|min:8|confirmed',
                'profilePic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'businessPermitPic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'governmentIdPic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'codeotp' => 'required|digits:6',
            ]);
            $profilePicPath = null;
            $businessPermitPath = null;
            $governmentIdPath = null;
           if ($request->hasFile('profilePic')) {
            $image = $request->file('profilePic');
            $imageName = time() . '_profile.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/uploads/profilePic', $imageName);
            $profilePicPath = 'storage/uploads/profilePic/' . $imageName;
          }

            if ($request->hasFile('businessPermitPic')) {
                $image = $request->file('businessPermitPic');
                $imageName = time() . '_permit.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/uploads/businessPermitPic', $imageName);
                $businessPermitPath = 'storage/uploads/businessPermitPic/' . $imageName;
            }

            if ($request->hasFile('governmentIdPic')) {
                $image = $request->file('governmentIdPic');
                $imageName = time() . '_govid.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/uploads/governmentIdPic', $imageName);
                $governmentIdPath = 'storage/uploads/governmentIdPic/' . $imageName;
            }
              $landlordID = Str::uuid();
               $verifyOtp = OtpModels::where('email',$validated['email'])
            ->where('otpCode',$validated['codeotp'])
            ->where('otpExpires_at', '>', now())
            ->first();
            // Store the tenant data
            if(!$verifyOtp)
            {
                  return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP Submission. Please try again.',
                'data' => null

            ],400);
        }
            $create = landlordAccountModel::create([
                'landlord_id' => $landlordID,
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'phonenumber' => $validated['phonenumber'],
                'password_hash' => bcrypt($validated['password']),
                'profile_pic_url' => $profilePicPath,
                'business_permit' => $businessPermitPath,
                'goverment_id' => $governmentIdPath,
                ]);
                 $verifyOtp->where('email',$validated['email'])->forceDelete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Welcome aboard! DormHub is happy to have you.',
                ],200);
            

        }
        catch(\Illuminate\Validation\ValidationException $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function resendOtp(Request $request)
{
    $validated = $request->validate([
         'email' => 'required|email',
    ],
    [   
        'email.exists' => 'No OTP record found for this email.',
    ]);
    try{
         $otpRecord = OtpModels::where('email',$validated['email']);
    if(!$otpRecord)
    {
        return response()->json([
            'message' => 'No OTP record found for this email',
        ]);
    }
                $newOtp = rand(100000, 999999);
                $newOtpExpiresAt = now()->addMinutes(1);
                   $otpRecord->update([
            'otpCode' => $newOtp,
            'otpExpires_at' => $newOtpExpiresAt, 
        ]);
                Mail::to($validated['email'])->send(new tenantEmailOtp($newOtp));
                 return response()->json([
            'status' => 'success',
            'message' => 'A new OTP has been sent to your email.',
            'timer' => $newOtpExpiresAt
        ], 200);



    }
    catch(Exception $ex)
{   
    \Log::error('Unexpected Error in ResendOtp:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'message' => 'An unexpected error occurred. Please try again.',
        ], 500);
   
}

}
public function loginLandlord(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\landlord\landlordAccountModel::where('email', $request->email)->first();

    if (!$user || !\Hash::check($request->password, $user->password_hash)) {
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

session([
    'landlord_logged_in' => true,
    'landlord_id' => $user->landlord_id,
    'landlord_firstname' => $user->firstname,
    'landlord_lastname' => $user->lastname,
    'landlord_avatar' => $user->profile_pic_url
]);

    return response()->json([
        'message' => 'Login successful',
        'status' => 'success',
        'landlord' => [
            'id' => $user->landlord_id,
            'firstname' =>$user->firstname,
            'lastname' =>$user->lastname,
        ],

    ]);
}
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/landlordLogin');
}


}
