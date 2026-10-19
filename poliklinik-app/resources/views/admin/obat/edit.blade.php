<x-layouts.app title="Edit Obat">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('obat.index') }}"
           style="background-color: #e2e8f0; color: #334155;"
           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800" style="color: #1e293b;">
            Edit Obat
        </h2>
    </div>

    {{-- Alert Error --}}
    @if(session('error'))
    <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca;"
         class="flex items-center gap-2 p-4 mb-4 rounded-xl shadow-sm text-sm font-medium">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Card Form --}}
    <div class="bg-white shadow-md rounded-2xl border border-slate-200" style="background-color: #ffffff;">
        <div class="p-8">

            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Obat --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Nama Obat <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <input type="text"
                           name="nama_obat"
                           value="{{ old('nama_obat', $obat->nama_obat) }}"
                           placeholder="Masukkan nama obat..."
                           style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                           class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 placeholder-slate-400 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('nama_obat') border-red-500 @enderror"
                           required>

                    @error('nama_obat')
                    <p class="text-xs text-red-500 mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kemasan --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Kemasan <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <input type="text"
                           name="kemasan"
                           value="{{ old('kemasan', $obat->kemasan) }}"
                           placeholder="Masukkan kemasan obat..."
                           style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                           class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 placeholder-slate-400 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('kemasan') border-red-500 @enderror"
                           required>

                    @error('kemasan')
                    <p class="text-xs text-red-500 mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Harga (Rp) <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <input type="number"
                           name="harga"
                           min="0"
                           value="{{ old('harga', $obat->harga) }}"
                           placeholder="Masukkan harga obat..."
                           style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                           class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 placeholder-slate-400 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('harga') border-red-500 @enderror"
                           required>

                    @error('harga')
                    <p class="text-xs text-red-500 mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            style="background-color: #2d4499; color: #ffffff;"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-800 hover:bg-blue-900 text-white rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                        <i class="fas fa-save"></i>
                        <span>Simpan</span>
                    </button>

                    <a href="{{ route('obat.index') }}"
                       style="background-color: #e2e8f0; color: #334155;"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-semibold transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>