<?php

// app\Http\Controllers\Api\admin\AuthController.php
// app\Http\Controllers\Api\admin\AuthController.php

namespace App\Http\Controllers\Api\admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required_without:name|email',
            'name' => 'required_without:email|string',
            'password' => 'required',
        ],);
    
        // Cari pengguna berdasarkan email dan username
        $admin = Admin::where('email', $request->input('email'))
                    ->orWhere('name', $request->input('name'))
                    ->first();
        
        
        // Pastikan pengguna ada dan password sesuai
        if ($admin && Hash::check($request->input('password'), $admin->password)) {
            // Update waktu login dan generate remember_token
            $admin->update([
                'last_login_at' => now(),
                'api_token' => $rememberToken = Str::random(6),
            ]);
    
            // Otentikasi berhasil
            Auth::loginAdmin($admin);
    
            return response()->json([
                'status' => true,
                'message' => 'Login Admin Berhasil',
                'user' => $admin,
                'api_token' => $rememberToken,
            ]);
        } else {
            // Otentikasi gagal
            return response()->json([
                'status' => false,
                'message' => 'Email atau Password salah',
            ], 401);
        }
    }
    

    public function logout(Request $request)
    {
        // Ambil admin yang sedang login
        $admin = Auth::guard('admin')->user();
        $admin = Admin::where('email', $request->input('email'))->first();
    
        if ($admin) {
            // Perbarui waktu logged_out_at dan remember_token
            $admin->update([
                'logged_out_at' => now(),
                'remember_token' => null,
            ]);
        }
    
        // Logout pengguna
    
        return response()->json(['message' => 'Logout berhasil']);
    }
    
}    