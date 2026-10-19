<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Menampilkan daftar jadwal periksa milik dokter yang sedang login.
     */
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('dokter.jadwal-periksa.index', compact('jadwalPeriksas'));
    }

    /**
     * Menampilkan form tambah jadwal.
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Menyimpan data jadwal baru dengan validasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari'        => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ], [
            'hari.required'        => 'Hari praktik wajib dipilih.',
            'hari.in'              => 'Pilihan hari tidak valid.',
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after'    => 'Jam selesai harus lebih akhir dari jam mulai.',
        ]);

        // Cek apakah ada jadwal yang bentrok pada hari yang sama
        $bentrok = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $validated['hari'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                      ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('jam_mulai', '<=', $validated['jam_mulai'])
                            ->where('jam_selesai', '>=', $validated['jam_selesai']);
                      });
            })->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal pada hari dan rentang jam tersebut bentrok dengan jadwal Anda yang lain.');
        }

        JadwalPeriksa::create([
            'id_dokter'   => Auth::id(),
            'hari'        => $validated['hari'],
            'jam_mulai'   => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal milik dokter yang login.
     */
    public function edit(string $id)
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
        return view('dokter.jadwal-periksa.edit', compact('jadwalPeriksa'));
    }

    /**
     * Memperbarui data jadwal periksa dengan validasi.
     */
    public function update(Request $request, string $id)
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);

        $request->merge([
            'jam_mulai'   => substr($request->jam_mulai, 0, 5),
            'jam_selesai' => substr($request->jam_selesai, 0, 5),
        ]);

        $validated = $request->validate([
            'hari'        => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ], [
            'hari.required'        => 'Hari praktik wajib dipilih.',
            'hari.in'              => 'Pilihan hari tidak valid.',
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after'    => 'Jam selesai harus lebih akhir dari jam mulai.',
        ]);

        $jadwalPeriksa->update($validated);

        return redirect()->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil diperbarui.');
    }

    /**
     * Menghapus data jadwal periksa.
     */
    public function destroy(string $id)
    {
        try {
            $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
            $jadwalPeriksa->delete();

            return redirect()->route('jadwal-periksa.index')
                ->with('success', 'Jadwal periksa berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('jadwal-periksa.index')
                ->with('error', 'Jadwal periksa tidak dapat dihapus karena sudah memiliki data antrean pasien.');
        }
    }
}