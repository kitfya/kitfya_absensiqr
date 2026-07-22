<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkademikController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    // Tampilkan halaman gabungan Jurusan & Kelas
    public function index()
    {
        $jurusanRef = $this->database->getReference('jurusan')->getValue() ?? [];
        $kelasRef = $this->database->getReference('kelas')->getValue() ?? [];
        $siswaRef = $this->database->getReference('siswa')->getValue() ?? [];

        return view('akademik.index', compact('jurusanRef', 'kelasRef', 'siswaRef'));
    }

    // --- CRUD JURUSAN ---
    public function storeJurusan(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode' => 'required|string|max:10'
        ]);

        $data = [
            'nama_jurusan' => $request->nama_jurusan,
            'kode' => strtoupper($request->kode),
        ];

        $this->database->getReference('jurusan')->push($data);
        return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function updateJurusan(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode' => 'required|string|max:10'
        ]);

        $dataUpdate = [
            'nama_jurusan' => $request->nama_jurusan,
            'kode' => strtoupper($request->kode),
        ];

        $this->database->getReference('jurusan/' . $id)->update($dataUpdate);
        return redirect()->back()->with('success', 'Jurusan berhasil diperbarui!');
    }

    public function destroyJurusan($id)
    {
        $this->database->getReference('jurusan/' . $id)->remove();
        return redirect()->back()->with('success', 'Jurusan berhasil dihapus!');
    }

    // --- CRUD KELAS ---
    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|string'
        ]);

        $data = [
            'nama_kelas' => $request->nama_kelas,
            'jurusan_id' => $request->jurusan_id,
        ];

        $this->database->getReference('kelas')->push($data);
        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|string'
        ]);

        $dataUpdate = [
            'nama_kelas' => $request->nama_kelas,
            'jurusan_id' => $request->jurusan_id,
        ];

        $this->database->getReference('kelas/' . $id)->update($dataUpdate);
        return redirect()->back()->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroyKelas($id)
    {
        $this->database->getReference('kelas/' . $id)->remove();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }
}