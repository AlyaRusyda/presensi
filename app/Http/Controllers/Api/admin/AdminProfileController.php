<?php

namespace App\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function editAdmin($id)
    {
        $admin = Admin::find($id);
        return view('profile.edit.admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);
    
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }else{
            $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
        ]);

        $emaillama = $admin->email;
        $namalama = $admin->nama;
        $admin->nama = $request->input('nama');
        $admin->email = $request->input('email');

        if($admin->email == $emaillama){
            $em = "";
        }else{
            $em = $admin->email;
        }

        $admin->save();
            

        if($emaillama != $admin->email){
            $pesan = 'Data berhasil di update dengan email diubah dari ' . $emaillama . ' ke ' . $admin->email;
        }elseif ($namalama != $admin->nama){
            $pesan = 'Data berhasil di update dengan nama ' . $admin->nama;
        }else{
            $pesan = 'Data berhasil di update!';
        }
    
        return response()->json(['message' => $pesan], 200);
        }
    
    }
    
    public function seeAdmin()
    {
        $admin = Admin::all();
        return response()->json([
            'succes' => true,
            'message' => 'Berikut adalah list data admin yang ada',
            'data' => $admin,
        ]);
    }
}