<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendidikan;

class PendidikanController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nama_pendidikan' => 'required',
        ]);

        $pendidikan = new Pendidikan;
        $pendidikan->nama_pendidikan = $request->input('nama_pendidikan');
        $pendidikan->save();

        return response()->json(['message' => 'Pendidikan telah berhasil ditambahkan'], 201);
    }

    public function getAll()
    {
        $pendidikans = Pendidikan::all();
        return response()->json(['data' => $pendidikans], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pendidikan' => 'required',
        ]);
    
        $pendidikan = Pendidikan::find($id);
    
        if (!$pendidikan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $pendidikan->nama_pendidikan = $request->input('nama_pendidikan');
        $pendidikan->save();
    
        return response()->json(['message' => 'Data berhasil diupdate'], 200);
    }

    public function delete($id)
    {
        $pendidikan = Pendidikan::find($id);
    
        if (!$pendidikan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $pendidikan->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
