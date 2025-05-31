<?php

namespace App\Http\Controllers\landloard\auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\landlord\landlordAccountModel;
use App\Models\landlord\landlordRoomModel;
use App\Models\landlord\landlordDormManagement;

use Illuminate\Support\Facades\Auth;

class roomManagementController extends Controller
{
    public function RoomManagement($landlordId)
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
        $dorms = landlordDormManagement::where('landlord_id', $landlordId)->get();
        return view ('landlord.auth.roomManagement', ['title' => 'Landlord - Room Management',
        'headerName' => 'Room Management',
        'color' =>'primary',
        'landlord' => $landlord,
        'dorms' => $dorms,
    ]);
    }
    public function addRoom(Request $request)
    {
        $request->validate([
            
            'dormsId' => 'required|string|max:255',
            'roomNumber' => 'required|string|max:255',
            Rule::unique('rooms')->where(function ($query) use ($request) {
                return $query->where('dormitory_id', $request->input('dormsId'))
                             ->where('room_number', $request->input('roomNumber'));
            }),
            'roomType' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',  
            'price' => 'required|numeric|min:0',
        ],
        [
            'roomNumber.required' => 'Room number is required.',
            'roomNumber.unique' => 'This room number already exists in the selected dormitory.',
        ]
    );
        try
        {
            $landlordId = session('landlord_id'); // Move inside method
            
                // $randomRoomId = rand(1000, 9999);
        

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
            $room = new landlordRoomModel();
            $room->dormitory_id = $request->input('dormsId');
            $room->landlord_id = $landlordId; 
            $room->room_number = $request->input('roomNumber');
            $room->availability = $request->input('availability');
            $room->capacity = $request->input('capacity');
            $room->room_type = $request->input('roomType');
            $room->price = round($request->input('price'), 2);
            $room->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Room added successfully.',
                'room' => $room
            ]);
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
                'input' => $request->all(),

            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                'input' => $request->all(),  // Send the input back to frontend

            ], 500);
        }
        
    }
    public function ListRooms(Request $request)
    {
        $landlordId = session('landlord_id');
    
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
    
        $rooms = landlordRoomModel::where('landlord_id', $landlordId)->get();
    
        return response()->json([
            'status' => 'success',
            'rooms' => $rooms
        ]);
    }
    public function ViewRoom($id)
    {
        $landlordId = session('landlord_id');
        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }
    
        // Fetch the room by ID with its dorm info
        $room = DB::table('rooms as rooms')
            ->join('dorms as dorms', 'rooms.dormitory_id', '=', 'dorms.dorm_id')
            ->where('rooms.room_id', $id)
            ->where('rooms.landlord_id', $landlordId)
            ->select('rooms.*', 'dorms.dorm_name', 'dorms.address', 'dorms.contact_email', 'dorms.contact_phone', 'dorms.rules')
            ->first();
    
        // Check if the room exists
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found.'
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'room' => $room
        ]);
    }
    
    
}
