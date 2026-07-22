<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    // Tampilkan halaman data siswa
    public function index()
    {
        // Berikan fallback ?? [] jika node di Firebase belum terisi data sama sekali
        $siswaRef = $this->database->getReference('siswa')->getValue() ?? [];
        $kelasRef = $this->database->getReference('kelas')->getValue() ?? [];
        $jurusanRef = $this->database->getReference('jurusan')->getValue() ?? [];

        return view('siswa.index', compact('siswaRef', 'kelasRef', 'jurusanRef'));
    }

    // Simpan Siswa Baru
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        $data = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        $this->database->getReference('siswa')->push($data);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    // Update Data Siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        $dataUpdate = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        // Menuju node siswa/{id} berdasarkan KEY enkripsi unik bawaan push() Firebase
        $this->database->getReference('siswa/' . $id)->update($dataUpdate);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Hapus Data Siswa
    public function destroy($id)
    {
        $this->database->getReference('siswa/' . $id)->remove();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus!');
    }
}