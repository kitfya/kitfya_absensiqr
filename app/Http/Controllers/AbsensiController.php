<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    // Tampilkan halaman riwayat absensi
    public function riwayat(Request $request)
    {
        // Jika admin memilih tanggal, gunakan tanggal itu. Jika tidak, default ke tanggal hari ini.
        $tanggalTerpilih = $request->get('tanggal', date('Y-m-d'));

        // Ambil data absensi berdasarkan tanggal terpilih dari Firebase
        $absensiRef = $this->database->getReference('riwayat_absensi/' . $tanggalTerpilih)->getValue();
        
        // Ambil data siswa dan kelas untuk mencocokkan ID dengan nama asli siswa
        $siswaRef = $this->database->getReference('siswa')->getValue();
        $kelasRef = $this->database->getReference('kelas')->getValue();

        return view('absensi.riwayat', compact('absensiRef', 'siswaRef', 'kelasRef', 'tanggalTerpilih'));
    }

    // Fungsi opsional untuk admin mengubah status absen siswa (misal dari "Hadir" jadi "Izin")
    public function updateStatus(Request $request, $tanggal, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Terlambat,Sakit,Izin'
        ]);

        $this->database->getReference('riwayat_absensi/' . $tanggal . '/' . $id)->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status absensi berhasil diperbarui!');
    }

    public function pengaturanJadwal()
{
    $jadwal = $this->database->getReference('jadwal_absensi')->getValue();
    return view('absensi.jadwal', compact('jadwal'));
}

// Simpan perubahan jadwal ke Firebase
public function simpanJadwal(Request $request)
{
    $request->validate([
        'mulai' => 'required',
        'batas_hadir' => 'required',
        'selesai' => 'required',
    ]);

    $this->database->getReference('jadwal_absensi')->set([
        'mulai' => $request->mulai,
        'batas_hadir' => $request->batas_hadir,
        'selesai' => $request->selesai,
    ]);

    return redirect()->back()->with('success', 'Jadwal absensi berhasil diperbarui!');
}
}