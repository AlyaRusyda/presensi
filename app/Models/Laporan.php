<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Laporan extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'laporan';
    protected $primaryKey = 'id_pemagang';

    
    protected $fillable= [
        'id_pemagang',
        'no',
        'tgl_hari_ini',
        'jam_masuk',
        'jam_pulang',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
        'jam_izin_mulai',
        'jam_izin_selesai',
        'total_jam_kerja',
        'status_kehadiran',
        'ganti_jam',
    ];
}