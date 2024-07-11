<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RegisterRequest;
use App\Services\ProjectService;

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
            if (auth()->user()->email_verified_at === null) {
                auth()->logout();
                return back()->withErrors([
                    'credentials' => 'Akun Anda masih belum dikonfirmasi admin.',
                ]);
            }

            $request->session()->regenerate();
            if (auth()->user()->hasRole('Admin')) {

                return redirect()->route('dashboard.admin.user-management.index');
            } elseif (auth()->user()->hasRole('Platinum Member')) {
                return redirect()->route('dashboard.user.project-management.index');
            }
        }

        return back()->withErrors([
            'credentials' => 'Email atau password salah',
        ]);
    }

    public function postRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated() + ['password' => bcrypt($request->password)]);

            $role = Role::where('name', 'Platinum Member')->first();
            $user->assignRole($role);

            if ($request->hasFile('supporting_documents')) {
                foreach ($request->file('supporting_documents') as $file) {
                    $user->addMedia($file)->toMediaCollection('supporting_documents');
                }
            }

            DB::commit();
            return redirect()->route('login')->with('success', 'Pendaftaran Berhasil, Silahkan menunggu admin konfirmasi akun anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'credentials' => 'Pendaftaran gagal, silahkan coba lagi.',
            ]);
        }
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
