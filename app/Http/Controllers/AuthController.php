<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register_user(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        $user->assignRole('user');
        return redirect('/');
    }

    public function login_user(Request $request)
    {

        // Validate the incoming request data
        $credentials = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($credentials->fails()) {
            return back()->with('credentials', $credentials->errors(), 400);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            if (request()->user()->hasrole('admin')) {
                
                return redirect()->intended('dashboard/home');
            } else {
               
                return redirect()->intended('dashboard/home');
            }
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout_user()
    {
        Auth::logout();
        return redirect('/');
    }
}
