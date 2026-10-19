<x-layouts.app title="Edit Jadwal Periksa">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('jadwal-periksa.index') }}"
           style="background-color: #e2e8f0; color: #334155;"
           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800" style="color: #1e293b;">
            Edit Jadwal Periksa
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

            <form action="{{ route('jadwal-periksa.update', $jadwalPeriksa->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Hari --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Hari Praktik <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <select name="hari"
                            style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                            class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('hari') border-red-500 @enderror"
                            required>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari', $jadwalPeriksa->hari) === $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>

                    @error('hari')
                    <p class="text-xs text-red-500 mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Mulai --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Jam Mulai <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <input type="time"
                           name="jam_mulai"
                           value="{{ old('jam_mulai', substr($jadwalPeriksa->jam_mulai, 0, 5)) }}"
                           style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                           class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('jam_mulai') border-red-500 @enderror"
                           required>

                    @error('jam_mulai')
                    <p class="text-xs text-red-500 mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Selesai --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" style="color: #334155;">
                        Jam Selesai <span class="text-red-500" style="color: #ef4444;">*</span>
                    </label>

                    <input type="time"
                           name="jam_selesai"
                           value="{{ old('jam_selesai', substr($jadwalPeriksa->jam_selesai, 0, 5)) }}"
                           style="background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1;"
                           class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 text-sm focus:border-blue-700 focus:outline-none @error('jam_selesai') border-red-500 @enderror"
                           required>

                    @error('jam_selesai')
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

                    <a href="{{ route('jadwal-periksa.index') }}"
                       style="background-color: #e2e8f0; color: #334155;"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-semibold transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>