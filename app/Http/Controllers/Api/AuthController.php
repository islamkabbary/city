<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Phone;
use App\Helpers\SMSHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required',
                'password' => ['nullable', Password::min(6)],
            ]);
            $user = User::where('phone', $request->phone)->first();
            if ($user == null || $user->verify_phone == 0) {
                $code = $this->sendCode($request->phone);
                return response()->json(['status' => 1, 'code' => 400, 'message' => 'User Not Found', 'data' => $code], 404);
            } elseif ($user->name == null && $user->password == null) {
                return response()->json(['status' => 2, 'code' => 400, 'message' => 'User Not Register'], 404);
            } elseif ($token = JWTAuth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
                $data['token'] = $token;
                $data['user'] = $user;
                return response()->json(['status' => 3, 'code' => 200, 'message' => 'Login Successfully', 'data' => $data], 404);
            } else {
                return response()->json(['status' => 0, 'code' => 400, 'message' => 'Invalid Credentials'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 404);
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                $user->verify_phone = 1;
                $user->phone = $request->phone;
                $user->save();
                return response()->json(['status' => 1, 'code' => 200, 'message' => trans('succeeded')], Response::HTTP_OK);
            } else {
                return response()->json(['status' => 0, 'code' => 400, 'message' => trans('wrong data')], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 404);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(6)],
                'name' => 'required',
                'phone' => 'required|exists:users,phone'
            ]);
            $user = User::where('phone', $request->phone)->first();
            $user->name = $request->name;
            $user->type = 'client';
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Registered Successfully', 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'code' => 400, 'message' => $e->getMessage()], 404);
        }
    }

    public function sendCode($phone, $text = null)
    {
        $user = User::where('phone', $phone)->first();
        if ($user) {
            $user->code = rand(100000, 999999);
            $user->save();
            $message = new SMSHelper();
            // if ($text != null) {
            //     $message->sendMessage($text . ' ' . $user->code, $user->mobile);
            // } else {
            //     $message->sendMessage(trans('code has been sent to your phone') . ' ' . $user->code, $user->mobile);
            // }
            return response()->json(['status' => 1, 'code' => 200, 'message' => $user->code]);
        } else {
            $newUser = new User();
            $newUser->phone = $phone;
            $newUser->type = 'client';
            $newUser->code = rand(100000, 999999);
            $newUser->save();
            // $message = new SMSHelper();
            // if ($text != null) {
            //     $message->sendMessage($text . ' ' . $newUser->code, $newUser->mobile);
            // } else {
            //     $message->sendMessage(trans('code has been sent to your phone') . ' ' . $newUser->code, $newUser->mobile);
            // }
            // return $newUser->code;
            return response()->json(['status' => 1, 'code' => 200, 'message' => $newUser->code]);
        }
    }

    public function logOut(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('User has been logged out'), 'data' => null]);
        } catch (JWTException $exception) {
            return response()->json(['status' => 0, 'code' => 400, 'message' => trans('Sorry user cannot be logged out'), 'data' => null], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
