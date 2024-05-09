<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
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
                'legal_document' => 'required|mimes:pdf|max:2048',
            ],
        );


        $createdUser = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => Role::where('name', 'Owner')->first()->id,
        ]);

        // store document to companies/owner_id/legal_document
        $legalDocument = $request->file('legal_document');
        $legalDocumentName = time() . '_' . Str::uuid() . '.' . 'pdf';
        $legalDocument->storeAs('companies/legal_document/' . $createdUser->id, $legalDocumentName);

        // store company data
        $companyData = [
            'owner_id' => $createdUser->id,
            'name' => $validatedData['company_name'],
            'description' => $validatedData['company_description'],
            'address' => $validatedData['company_address'],
            'logo' => $validatedData['company_logo'],
            'city' => $validatedData['company_city'],
            'country' => $validatedData['company_country'],
            'phone' => $validatedData['company_phone'],
            'employee_count' => $validatedData['company_employee_count'],
            'established_year' => $validatedData['company_established_year'],
            'legal_document' => $legalDocumentName,
        ];

        DB::commit();

        return view('auth.credentials.on_confirmation');
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
