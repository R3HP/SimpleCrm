<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Login Page
    public function create()
    {
        return view('Auth.login');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $isLoginSuccess = Auth::attempt($request->only(['email','password','first-name','last-name']));

        if ($isLoginSuccess) {
            return redirect(route('home'))->with('succes', ' Logged In Successfully');
        } else {
            return redirect()->back()->with('fail', 'Could Not Log In');
        }
    }

    public function edit(User $user){
        return view('Auth.edit',compact('user'));
    }

    public function update(ChangePasswordRequest $request){
        $user = Auth::user();
        if ($request->validated()) {
            if(Hash::check($request->old_password,$user->password)){
                $user->update(['password' => Hash::make($request->new_password)]);
                return redirect()->route('users.index')->with('success','Password Changed');
            }
        }
        return redirect()->back(502);
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
