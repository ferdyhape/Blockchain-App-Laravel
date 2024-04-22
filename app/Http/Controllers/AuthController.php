<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.credentials.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
        );

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if (checkRoles(['Admin'])) {
                return redirect()->route('dashboard.admin.index');
            } elseif (checkRoles(['Admin', 'Shareholder'])) {
                return redirect()->route('dashboard.shareholder.index');
            } elseif (checkRoles(['Admin', 'Owner'])) {
                return redirect()->route('dashboard.owner.index');
            }
        }

        return back()->withErrors([
            'credentials' => 'The provided credentials do not match our records.',
        ]);
    }


    public function postRegisterOwner(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|confirmed',
                'company_name' => 'required',
                'company_description' => 'required',
                'company_address' => 'required',
                'company_logo' => 'required',
                'company_city' => 'required',
                'company_country' => 'required',
                'company_phone' => 'required',
                'company_employee_count' => 'required',
                'company_established_year' => 'required',
            ],
        );

        // $credentials['password'] = bcrypt($validatedData['password']);

        // $user = User::create($credentials);
    }


    public function postRegisterShareholder(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|confirmed',
            ],
        );
        dd($validatedData);

        // $credentials['password'] = bcrypt($validatedData['password']);

        // $user = User::create($credentials);
    }



    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }

    public function register()
    {
        return view('auth.credentials.register');
    }
}
