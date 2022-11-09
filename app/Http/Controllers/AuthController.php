<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function viewLogin()
    {
        return view('auth.login');
    }

    public function viewRegis()
    {
        return view('auth.register');
    }

    public function customLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all());
        } else {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                $cek = User::where('username', $request->username)->first();
                $cek->save();
                    return redirect()->intended('home')
                    ->withSuccess('Signed in');

            }
        }
        return redirect()->back()->with('error', 'Username Tidak Valid');
    }

    public function customRegis(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => ['required','min:6']
        ]);

        if ($validator->fails()) {
            if($validator->errors()->first() == 'The name field is required.' ||
               $validator->errors()->first() == 'The phone field is required.' ||
               $validator->errors()->first() == 'The norek field is required.' ||
               $validator->errors()->first() == 'The alamat field is required.' ||
               $validator->errors()->first() == 'The password field is required.'
            ){

                return redirect()->back()->with('error', 'Harap Lengkapi Seluruh Inputan');
            }

        } else {
            $data = $request->all();
            $cek = User::where('username', $request->username)->first();
            if(!$cek){
                $data['password'] = Hash::make($request->password);
                $this->user->create($data);
                return redirect()->route('view.login');
            } else {
                return redirect()->back()->with('error', 'Maaf username telah digunakan');
            }
        }
    }
}
