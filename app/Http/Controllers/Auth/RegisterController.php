<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function __construct(){
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        // validate, you can check for matching data with _confirmed in their name like password
        $this->validate($request, [
            'name' => 'required|max:300',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // store user, make sure we hash the password
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // sign user in
        auth()->attempt($request->only('email','password'));

        // redirect
        return redirect()->route('dashboard');

    }
}
