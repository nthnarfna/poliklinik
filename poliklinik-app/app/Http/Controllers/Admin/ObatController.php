<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Menampilkan daftar obat.
     */
    public function index()
    {
        $obats = Obat::orderBy('nama_obat', 'asc')->get();
        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Menampilkan form tambah obat.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Menyimpan data obat baru dengan validasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kemasan'   => ['required', 'string', 'max:255'],
            'harga'     => ['required', 'integer', 'min:0'],
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kemasan.required'   => 'Kemasan obat wajib diisi.',
            'harga.required'     => 'Harga obat wajib diisi.',
            'harga.integer'      => 'Harga obat harus berupa angka.',
            'harga.min'          => 'Harga obat tidak boleh kurang dari 0.',
        ]);

        Obat::create($validated);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit obat.
     */
    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Memperbarui data obat dengan validasi.
     */
    public function update(Request $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kemasan'   => ['required', 'string', 'max:255'],
            'harga'     => ['required', 'integer', 'min:0'],
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kemasan.required'   => 'Kemasan obat wajib diisi.',
            'harga.required'     => 'Harga obat wajib diisi.',
            'harga.integer'      => 'Harga obat harus berupa angka.',
            'harga.min'          => 'Harga obat tidak boleh kurang dari 0.',
        ]);

        $obat->update($validated);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    /**
     * Menghapus data obat dengan penanganan relasi database.
     */
    public function destroy(string $id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

            return redirect()->route('obat.index')
                ->with('success', 'Data obat berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena masih digunakan pada data riwayat pemeriksaan.');
        }
    }
}