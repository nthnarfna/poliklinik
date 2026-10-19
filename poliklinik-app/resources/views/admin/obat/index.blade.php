<x-layouts.app title="Data Obat">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800" style="color: #1e293b;">
                Manajemen Obat
            </h2>
            <p class="text-sm text-slate-500 mt-1">Daftar obat yang tersedia untuk pelayanan poliklinik</p>
        </div>

        <a href="{{ route('obat.create') }}"
           style="background-color: #2d4499; color: #ffffff;"
           class="inline-flex items-center gap-2 bg-blue-800 hover:bg-blue-900 text-white font-semibold text-sm rounded-lg px-5 py-2.5 shadow-sm transition">
            <i class="fas fa-plus"></i>
            <span>Tambah Obat</span>
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div style="background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0;"
         class="flex items-center gap-2 p-4 mb-4 rounded-xl shadow-sm text-sm font-medium">
        <i class="fas fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
    <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca;"
         class="flex items-center gap-2 p-4 mb-4 rounded-xl shadow-sm text-sm font-medium">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Card Tabel --}}
    <div class="bg-white shadow-md rounded-2xl border border-slate-200 overflow-hidden" style="background-color: #ffffff;">
        <div class="p-0">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    {{-- Head --}}
                    <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider border-b border-slate-200" style="background-color: #f1f5f9; color: #475569;">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-left">Nama Obat</th>
                            <th class="px-6 py-4 font-semibold text-left">Kemasan</th>
                            <th class="px-6 py-4 font-semibold text-left">Harga</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-slate-200 bg-white text-sm" style="background-color: #ffffff;">
                        @forelse($obats ?? [] as $obat)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800" style="color: #1e293b;">
                                {{ $obat->nama_obat }}
                            </td>

                            <td class="px-6 py-4 text-slate-600" style="color: #475569;">
                                {{ $obat->kemasan ?? '-' }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800" style="color: #1e293b;">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('obat.edit', $obat->id) }}"
                                       style="background-color: #f59e0b; color: #ffffff;"
                                       class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg px-3.5 py-2 shadow-sm transition">
                                        <i class="fas fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus obat ini?')"
                                                style="background-color: #ef4444; color: #ffffff;"
                                                class="inline-flex items-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg px-3.5 py-2 shadow-sm transition cursor-pointer">
                                            <i class="fas fa-trash"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-14 text-slate-500" style="color: #64748b;">
                                <i class="fas fa-pills text-3xl mb-3 block"></i>
                                Belum ada data obat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</x-layouts.app>