<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class QrController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    // Tampilkan halaman Generator QR di Web Admin
    public function index()
    {
        return view('qr.generator');
    }

    public function generateBaru()
{
    $waktuSekarang = now()->format('H:i'); // Ambil jam menit saat ini (ex: 20:15)
    
    // 1. Ambil batasan jadwal dari Firebase
    $jadwal = $this->database->getReference('jadwal_absensi')->getValue();
    
    // Default rentang jika belum di-set admin
    $jamMulai = $jadwal['mulai'] ?? '06:30';
    $jamSelesai = $jadwal['selesai'] ?? '16:00';

    // 2. VALIDASI BARU (Bypass Ganti Hari):
    // QR Code HANYA akan terkunci jika jam sekarang berada di antara setelah Jam Selesai SORE 
    // DAN sebelum Jam Mulai PAGI esok harinya.
    if ($waktuSekarang > $jamSelesai && $waktuSekarang < $jamMulai) {
        return response()->json([
            'success' => false,
            'message' => 'Sesi absensi hari ini sudah berakhir. Sampai jumpa besok pagi!',
            'updated_at' => now()->translatedFormat('H:i:s')
        ]);
    }

    // 3. Jika di luar rentang kunci di atas (termasuk subuh/lewat tengah malam), generator gas terus!
    $kodeBaru = \Illuminate\Support\Str::random(32);
    $waktuLengkap = now()->toDateTimeString();

    $this->database->getReference('qr_active')->set([
        'code' => $kodeBaru,
        'updated_at' => $waktuLengkap
    ]);

    return response()->json([
        'success' => true,
        'code' => $kodeBaru,
        'updated_at' => now()->translatedFormat('H:i:s')
    ]);
}
}