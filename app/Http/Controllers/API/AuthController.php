<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // REGISTER API
    public function register(Request $request)
    {
        $validator                  = Validator::make($request->all(), [
            'name'                  => 'required|string|max:191',
            'email'                 => 'required|email|string|unique:users,email',
            'password'              => 'required|min:8'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()
            ]);
        } else {
            $user               =  User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => bcrypt($request->password)
            ]);

            $token              = $user->createToken($user->email . '_Token')->plainTextToken;

            return response()->json([
                'status'        => 200,
                'username'      => $user->name,
                'token'         => $token,
                'message'        => 'Register Successfully'
            ]);
        }
    }

    // Login
    public function login(Request $request)
    {
        $validator              = Validator::make($request->all(), [
            'email'             => 'required|string|email',
            'password'          => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'            => 401,
                'message'           => 'Invalid creadentials'
            ]);
        } else {
            $token                  = $user->createToken($user->email . '_Token')->plainTextToken;

            return response()->json([
                'status'            => 200,
                'username'          => $user->name,
                'token'             => $token,
                'message'           => 'logged successfully.',
            ]);
        }
    }
}
