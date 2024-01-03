<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    function getall(){
        $presensi = Laporan::all();
        $pres = Laporan::all()->count();

        if(!$presensi){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Telah ditemukan ' . $pres . ' data',
                'data' => $presensi,
            ], 200);
        }
        
    }

    function izin($id){
        $presensie = Laporan::find($id, 'id_pemagang');


        if(!$presensie){
            return response()->json([
                'success' => false,
                'message' => 'User Tidak Ditemukan  ',
            ], 404);
        }else{
            $presensie->update([
                'tgl_hari_ini' => now()->toDateString(),
                'jam_masuk' => null,
                'jam_pulang' => null,
                'jam_istirahat_mulai' => null,
                'jam_istirahat_selesai' => null,
                'jam_izin_mulai' => null,
                'jam_izin_selesai' => null,
                'total_jam_kerja' => null,
                'status_kehadiran' => 'Izin',
                'ganti_jam' => null,
            ]);
            
            $presensie = Laporan::latest()->first();
            
            return response()->json([
                'success' => true,
                'message' => 'izin berhasil',
                'data' => $presensie    
            ], 200);
            
        }
    }

    function tidak_hadir(Request $request){
        $request->validate([
            'tgl' => 'required|date',
        ]);

        $tgl = $request->input('tgl');
        // $filter = $request->input('filter');

        $presensie = Laporan::where('tgl_hari_ini', $tgl)->where('status_kehadiran', "Tidak Hadir")->get();

        if(!$presensie){
            return response()->json([
                'success' => false,
                'message' => 'User Tidak Ditemukan  ',
            ], 404);
        }else{
            $presensie = Laporan::latest()->first();
            
            return response()->json([
                'success' => true,
                'message' => 'Ditemukan '.$presensie->count().' data',
                'data' => $presensie    
            ], 200);
            
        }
    }

    public function tidak_masuk($id){
        $presensi = Laporan::where('id_pemagang', $id)
                        ->where('status_kehadiran', 'Tidak Hadir')
                        ->first();
    
        if (!$presensi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data Tidak Hadir',
            ], 404);
        } else {
            $totalTidakHadir = Laporan::where('id_pemagang', $id)
                                ->where('status_kehadiran', 'Tidak Hadir')
                                ->count();
    
            return response()->json([
                'success' => true,
                'message' => 'Anda harus mengganti hari sebanyak ' . $totalTidakHadir . ' hari',
                'data' => $presensi,
            ], 200);
        }
    }
    
}