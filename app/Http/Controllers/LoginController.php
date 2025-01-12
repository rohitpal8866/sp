<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request){
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=> 'required|min:6',
        ])->validate();

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->with('error','Email does not exist');
        }
        if(!Hash::check($request->password, $user->password)){
            return back()->with('error','Password does not match');
        }
        Auth::login($user);
        return redirect()->route('dashboard.index');
    }
}
