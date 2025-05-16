<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        $level = DB::table('m_level')->get();
        return view('auth.register', compact('level'));
    }

    public function postRegister(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            try {
                $validatedData = $request->validate([
                    'username' => 'required|string|min:4|max:20|unique:m_user,username',
                    'nama' => 'required|string|max:255',
                    'password' => 'required|string|min:6|max:20|confirmed',
                    'level_id' => 'required|exists:m_level,level_id',
                ]);

                $user = new UserModel();
                $user->username = $validatedData['username'];
                $user->nama = $validatedData['nama'];
                $user->password = bcrypt($validatedData['password']);
                $user->level_id = $validatedData['level_id'];
                $user->save();

                Auth::login($user);

                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi Berhasil',
                    'redirect' => url('/')
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('register');
    }
}
