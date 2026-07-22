<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }
    // Simpan Kelas Baru
    public function store(Request $request)
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

    // Update Kelas
    public function update(Request $request, $id)
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

    // Hapus Kelas
    public function destroy($id)
    {
        $this->database->getReference('kelas/' . $id)->remove();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }
}