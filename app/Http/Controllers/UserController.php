<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
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
            $user->update([
                'image' => FileHelper::update_file('image/userProfile', $request->image, $user->image),
            ]);
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
}
