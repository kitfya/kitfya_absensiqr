<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurusanController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    public function store(Request $request)
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

    // --- FITUR UPDATE ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode' => 'required|string|max:10'
        ]);

        $dataUpdate = [
            'nama_jurusan' => $request->nama_jurusan,
            'kode' => strtoupper($request->kode),
        ];

        // Menuju ke node jurusan berdasarkan KEY unik Firebase-nya lalu update
        $this->database->getReference('jurusan/' . $id)->update($dataUpdate);

        return redirect()->back()->with('success', 'Jurusan berhasil diperbarui!');
    }

    // --- FITUR DELETE ---
    public function destroy($id)
    {
        // Menuju ke node jurusan berdasarkan KEY unik Firebase-nya lalu hapus
        $this->database->getReference('jurusan/' . $id)->remove();

        return redirect()->back()->with('success', 'Jurusan berhasil dihapus!');
    }
}