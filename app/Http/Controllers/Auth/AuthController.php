<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function loginUser(Request $request)
    {
        $validator = validator(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => false, 'message' => $validator->errors() ], 422);
        }
        $users = User::where('email', $request->email)->first();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Auth::login($users);
            return response()->json([ 'status' => true, 'message' => 'Login successfully' ], 200);
        } else {
            return response()->json([ 'status' => false, 'message' => ['password' => ['Wrong password.']] ], 422);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect('/login');
        }
    }

    public function registerUser(Request $request)
    {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => false, 'message' => $validator->errors() ], 422);
        }
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Auth::login($users);
        return response()->json([ 'status' => true, 'message' => 'Register successfully' ], 200);
    }
}
