<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $database;

    public function __construct()
    {
        // Hubungkan ke Firebase Realtime Database
        $this->database = app('firebase.database');
    }

    public function index()
    {
        // 1. Ambil data master untuk Counter
        $allSiswa = $this->database->getReference('siswa')->getValue() ?? [];
        $totalSiswa = count($allSiswa);
        
        $allKelas = $this->database->getReference('kelas')->getValue() ?? [];
        $totalKelas = count($allKelas);
        
        $allJurusan = $this->database->getReference('jurusan')->getValue() ?? [];
        $totalJurusan = count($allJurusan);

        // 2. Ambil total absen khusus HARI INI
        $hariIni = date('Y-m-d');
        $absenHariIni = $this->database->getReference('riwayat_absensi/' . $hariIni)->getValue() ?? [];
        $totalAbsenHariIni = count($absenHariIni);

        // ==========================================
        // TAMBAHAN DATA 1: AKTIVITAS TERKINI (LOG ABSEN)
        // ==========================================
        $aktivitasTerkini = [];
        if (!empty($absenHariIni)) {
            krsort($absenHariIni);
            $rawAktivitas = array_slice($absenHariIni, 0, 3, true);

            foreach ($rawAktivitas as $idLog => $log) {
                // Cari data nama kelas secara dinamis dari master kelas berdasarkan kelas_id milik siswa
                $siswaId = $log['siswa_id'] ?? '';
                $kelasId = $allSiswa[$siswaId]['kelas_id'] ?? ($log['kelas_id'] ?? '');
                $namaKelas = $allKelas[$kelasId]['nama_kelas'] ?? '-';

                $aktivitasTerkini[] = [
                    'nama' => $log['nama_siswa'] ?? ($allSiswa[$siswaId]['nama'] ?? 'Siswa'),
                    'kelas' => $namaKelas,
                    'status' => $log['status'] ?? 'Hadir', 
                    'jam' => isset($log['timestamp']) ? date('H:i', $log['timestamp'] / 1000) : date('H:i'), 
                    'keterangan' => $log['keterangan'] ?? 'Berhasil melakukan scan QR'
                ];
            }
        }

        // ==========================================
        // TAMBAHAN DATA 2: RINGKASAN TABEL DEPARTEMEN / JURUSAN
        // ==========================================
        $tabelDepartemen = [];
        foreach ($allJurusan as $idJurusan => $jurusanObj) {
            // Mengikuti struktur baru: 'nama_jurusan'
            $namaJurusan = $jurusanObj['nama_jurusan'] ?? '-'; 

            // 1. Dapatkan daftar ID Kelas yang berada di bawah naungan ID Jurusan ini
            $kelasDiJurusan = array_keys(array_filter($allKelas, function($k) use ($idJurusan) {
                return isset($k['jurusan_id']) && $k['jurusan_id'] == $idJurusan;
            }));

            // 2. Hitung total siswa yang memiliki 'kelas_id' di dalam list kelas jurusan ini
            $siswaDiJurusan = array_filter($allSiswa, function($s) use ($kelasDiJurusan) {
                return isset($s['kelas_id']) && in_array($s['kelas_id'], $kelasDiJurusan);
            });
            $countSiswaJurusan = count($siswaDiJurusan);

            // 3. Hitung berapa siswa di jurusan ini yang sudah melakukan absensi hari ini
            $absenJurusan = array_filter($absenHariIni, function($a) use ($kelasDiJurusan, $allSiswa) {
                $siswaId = $a['siswa_id'] ?? '';
                $kelasId = $allSiswa[$siswaId]['kelas_id'] ?? ($a['kelas_id'] ?? '');
                return in_array($kelasId, $kelasDiJurusan);
            });
            
            $countHadir = count($absenJurusan);
            $countAbsen = $countSiswaJurusan - $countHadir;

            // Persentase Kehadiran
            $persentaseStatus = $countSiswaJurusan > 0 ? round(($countHadir / $countSiswaJurusan) * 100) : 0;

            $tabelDepartemen[] = [
                'nama' => $namaJurusan,
                'total' => $countSiswaJurusan,
                'hadir' => $countHadir,
                'absen' => $countAbsen < 0 ? 0 : $countAbsen,
                'persentase' => $persentaseStatus
            ];
        }

        // 3. Ambil data 7 hari terakhir untuk Chart/Grafik
        $chartLabels = [];
        $chartData = [];
        $chartPercentages = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggalObj = now()->subDays($i);
            $formatTanggal = $tanggalObj->format('Y-m-d');
            $labelTanggal = $tanggalObj->translatedFormat('D, d M');

            $dataAbsenTgl = $this->database->getReference('riwayat_absensi/' . $formatTanggal)->getValue() ?? [];
            $jumlahHadir = count($dataAbsenTgl);

            $persentase = 0;
            if ($totalSiswa > 0) {
                $persentase = round(($jumlahHadir / $totalSiswa) * 100);
            }

            $chartLabels[] = $labelTanggal;
            $chartData[] = $jumlahHadir;
            $chartPercentages[] = $persentase;
        }

        return view('dashboard', compact(
            'totalSiswa', 
            'totalKelas', 
            'totalJurusan', 
            'totalAbsenHariIni',
            'chartLabels',
            'chartData',
            'chartPercentages',
            'aktivitasTerkini', 
            'tabelDepartemen'  
        ));
    }
}