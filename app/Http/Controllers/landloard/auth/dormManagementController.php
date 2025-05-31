<?php

namespace App\Http\Controllers\landloard\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\landlord\landlordAccountModel;
use App\Models\Landlord\landlordDormAnimitiesModel; // Assuming you have an Amenities model for dorm amenities
use App\Models\landlord\landlordAmintiesModel; // Assuming you have an Amenities model for general amenities
use App\Models\landlord\landlordDormManagement; // Assuming you have a Dorm model for dorm management

class dormManagementController extends Controller
{
    public function DormManagement($landlordId)
    {
        $sessionLandlordId = session('landlord_id');
    
        if (!$sessionLandlordId) {
            return redirect()->route('loginLandlord')->with('error', 'Please log in as a landlord.');
        }
    
        if ($landlordId !== $sessionLandlordId) {
            // Optional: you can log this attempt or show a 403 page
            return redirect()->route('loginLandlord')->with('error', 'Unauthorized access.');
        }
    
        $landlord = landlordAccountModel::find($landlordId);
        if (!$landlord) {
            return redirect()->route('loginLandlord')->with('error', 'Landlord not found.');
        }
    
        return view('landlord.auth.dormManagement', [
            'title' => 'Landlord - Dorm Management',
            'headerName' => 'Dorm Management',
            'color' => 'primary',
            'landlord' => $landlord,
        ]);
    }
    
    

   

    public function AddDorm(Request $request)
    {
        $landlordId = session('landlord_id'); // Move inside method

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        $validated = $request->validate([
            'dorm_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'total_rooms' => 'required|integer|min:1',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:11',
            'rules' => 'nullable|string',
        ],
        ['contact_phone.max' => 'The contact phone number must not exceed 11 characters.',
         'total_rooms.min' => 'The total rooms must be at least 1.',
         'total_rooms.integer' => 'The total rooms must be an number.',]);

        try {
            // Generate unique dorm ID
            do {
                $randomDormId = rand(1000, 9999);
            } while (landlordDormManagement::where('dorm_id', $randomDormId)->exists());

            $dorm = new landlordDormManagement();
            $dorm->dorm_id = $randomDormId;
            $dorm->dorm_name = $validated['dorm_name'];
            $dorm->address = $validated['address'];
            $dorm->landlord_id = $landlordId;
            $dorm->latitude = $validated['latitude'];
            $dorm->longitude = $validated['longitude'];
            $dorm->description = $validated['description'] ?? null;
            $dorm->total_rooms = $validated['total_rooms'];
            $dorm->available_rooms = $validated['total_rooms'];
            $dorm->contact_email = $validated['contact_email'];
            $dorm->contact_phone = $validated['contact_phone'];
            $dorm->rules = $validated['rules'] ?? null;

            $dorm->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Dorm added successfully!',
                'dormId' => $dorm->dorm_id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding dorm.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdateDorm(Request $request,$id)
    {
       $validated = $request->validate([
            'dorm_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'total_rooms' => 'required|integer|min:1',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:11',
            'rules' => 'nullable|string',
            
       ],
       ['contact_phone.max' => 'The contact phone number must not exceed 11 characters.',
        'total_rooms.min' => 'The total rooms must be at least 1.',
        'total_rooms.integer' => 'The total rooms must be an number.',]
    );

        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        // Fetch the dorm by ID
        $dorm = landlordDormManagement::where('dorm_id', $id)->where('landlord_id', $landlordId)->first();
        if (!$dorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dorm not found.'
            ], 404);
        }

        // Update dorm details
        $dorm->dorm_name = $validated['dorm_name'];
        $dorm->address = $validated['address'];
        $dorm->latitude = $validated['latitude'];
        $dorm->longitude = $validated['longitude'];
        $dorm->description = $validated['description'] ?? null;
        $dorm->total_rooms = $validated['total_rooms'];
        $dorm->contact_email = $validated['contact_email'];
        $dorm->contact_phone = $validated['contact_phone'];
        $dorm->rules = $validated['rules'] ?? null;

        // Save changes
        $dorm->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Dorm updated successfully!',
       ]);
    }

    public function DeleteDorm($id)
    {
        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        // Fetch the dorm by ID
        $dorm = landlordDormManagement::where('dorm_id', $id)->where('landlord_id', $landlordId)->first();
        if (!$dorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dorm not found.'
            ], 404);
        }

        // Delete the dorm
        $dorm->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dorm deleted successfully!'
        ]);
    }

    public function ViewDorm($id)
    {
        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
        // Fetch the dorm by ID
        $dorm = landlordDormManagement::with('amenities')
            ->where('dorm_id', $id)
            ->where('landlord_id', $landlordId)
            ->first();
        if (!$dorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dorm not found.'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'dorm' => $dorm
        ]);

    }

    public function ListDorms()
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        // Get dorms by landlord
        $dorms = landlordDormManagement::where('landlord_id', $landlordId)->paginate(2);

        return response()->json([
            'status' => 'success',
            'dorms' => $dorms,
            'landlord_id' => $landlordId
        ]);
    }
    public function searchDorms(Request $request)
    {
        $landlordId = session('landlord_id');
    
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
    
        $searchTerm = $request->input('search', '');
        $dorms = LandlordDormManagement::where('landlord_id', $landlordId)
            ->where(function ($query) use ($searchTerm) {
                $query->where('dorm_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('address', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(5);
    
        if ($dorms->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No dormitories found matching your search criteria.',
                'dorms' => $dorms
            ]);
        }
    
        return response()->json([
            'status' => 'success',
            'dorms' => $dorms
        ]);
    }
    public function AddAmenities(Request $request)
    {
        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
    
        $validated = $request->validate([
            'amenities' => 'required|string|max:255',
            'dorm_id' => 'required|integer',
        ]);
    
        try {
            $amenityName = trim($validated['amenities']);
            $dormId = $validated['dorm_id'];
    
            // First check if this amenity name already exists for this dorm
            $existingAmenity = landlordAmintiesModel::where('name', $amenityName)->first();
    
            if ($existingAmenity) {
                $exists = landlordDormAnimitiesModel::where('dorm_id', $dormId)
                    ->where('amenity_id', $existingAmenity->id)
                    ->exists();
    
                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This amenity already exists for this dormitory.'
                    ], 400);
                }
            }
    
            // Create the amenity if it doesn't exist globally
            $amenity = landlordAmintiesModel::firstOrCreate(
                ['name' => $amenityName]
            );
    
            // Link amenity to the dorm
            landlordDormAnimitiesModel::create([
                'dorm_id' => $dormId,
                'amenity_id' => $amenity->id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Amenity added successfully!',
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error adding amenities: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding amenities.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function DeleteAmenities($pivotId)
    {
        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Please log in.'
            ], 403);
        }
    
        $pivot = landlordDormAnimitiesModel::find($pivotId); // this is the pivot record
    
        if (!$pivot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity link not found.'
            ], 404);
        }
    
        // Check if the dorm_id belongs to the landlord
        $ownsDorm = landlordDormManagement::where('dorm_id', $pivot->dorm_id)
            ->where('landlord_id', $landlordId)
            ->exists();
    
        if (!$ownsDorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this amenity.'
            ], 403);
        }
    
        $pivot->delete(); // Delete the pivot record (unlink)
    
        return response()->json([
            'status' => 'success',
            'message' => 'Amenity removed from dorm.'
        ]);
    }
    
   
    
    


}