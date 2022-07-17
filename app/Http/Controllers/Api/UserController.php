<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\FileHelper;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function updateName(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $user = Auth::user();
            $user->update([
                'name' => $request->name,
            ]);
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Name updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $user = Auth::user();
            if ($user->image == null) {
                $user->update([
                    'image' => FileHelper::upload_file('image/userProfile', $request->image),
                ]);
            } else {
                $user->update([
                    'image' => FileHelper::update_file('image/userProfile', $request->image, $user->image),
                ]);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Image updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(6)],
                'old_password' => 'required',
            ]);
            if (Hash::check($request->old_password, auth()->user()->password)) {
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Password updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function addAddress(Request $request)
    {
        try {
            $request->validate([
                'building_type' => 'nullable|in:villa,Building',
                'location_type' => 'nullable|in:home,work,other',
                'district' => 'nullable',
                'street' => 'nullable',
                'building_number' => 'nullable',
                'apartment_number' => 'nullable',
                'floor' => 'nullable',
                'location_details' => 'nullable',
            ]);
            $user = Auth::user();
            $userAdress = new UserAddress();
            $userAdress->user_id = $user->id;
            $userAdress->building_type = $request->building_type ? $request->building_type : 'villa';
            $userAdress->location_type = $request->location_type ? $request->location_type : 'home';
            $userAdress->district = $request->district ? $request->district : null;
            $userAdress->street = $request->street ? $request->street : null;
            $userAdress->building_number = $request->building_number ? $request->building_number : null;
            $userAdress->apartment_number = $request->apartment_number ? $request->apartment_number : null;
            $userAdress->floor = $request->floor ? $request->floor : null;
            $userAdress->location_details = $request->location_details ? $request->location_details : null;
            $userAdress->save();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Address updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
