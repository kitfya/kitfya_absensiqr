<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end mb-8">
            <div>
                <nav class="flex items-center gap-2 text-label-caps text-secondary mb-2">
                    <span>Manajemen</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary font-bold">Riwayat Kehadiran</span>
                </nav>
                <h2 class="text-headline-xl font-headline-xl text-on-background">Riwayat Absensi Siswa</h2>
                <p class="text-body-md text-secondary mt-1">Pantau dan kelola rekaman log absensi harian secara real-time.</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <section class="mb-8">
        <form action="{{ route('absensi.riwayat') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-gutter items-end">
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] flex flex-col gap-2 md:col-span-3">
                <label for="tanggal" class="text-label-caps text-primary font-bold">PILIH TANGGAL ABSENSI</label>
                <div class="flex gap-4">
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggalTerpilih }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    <button type="submit" class="bg-primary hover:bg-primary-container text-white px-6 py-2 rounded-lg font-bold flex items-center gap-2 transition-all active:scale-95 shadow-md whitespace-nowrap">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                        Filter Data
                    </button>
                </div>
            </div>
            
            <div class="bg-primary p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.15)] flex flex-col justify-center text-on-primary h-[94px]">
                <p class="text-label-caps opacity-80 mb-1">TOTAL LOG MASUK</p>
                <h3 class="text-headline-lg font-bold">{{ !empty($absensiRef) ? count($absensiRef) : 0 }} Record</h3>
            </div>
        </form>
    </section>

    <section class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] overflow-hidden mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-low/50">
            <h3 class="text-title-md font-medium text-on-surface">
                📅 Data Absensi Tanggal: <span class="text-primary font-bold">{{ \Carbon\Carbon::parse($tanggalTerpilih)->translatedFormat('d F Y') }}</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="p-6 text-label-caps text-on-surface-variant">JAM SCAN</th>
                        <th class="p-6 text-label-caps text-on-surface-variant">NISN</th>
                        <th class="p-6 text-label-caps text-on-surface-variant">NAMA SISWA</th>
                        <th class="p-6 text-label-caps text-on-surface-variant">KELAS</th>
                        <th class="p-6 text-label-caps text-on-surface-variant text-center">STATUS</th>
                        <th class="p-6 text-label-caps text-on-surface-variant text-center">AKSI QUICK UPDATE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @if(!empty($absensiRef))
                        @foreach($absensiRef as $idSiswa => $absen)
                            @php
                                // Ambil NISN dan Kelas ID dari master data siswaRef secara aman
                                $nisnSiswa = $siswaRef[$idSiswa]['nisn'] ?? '-';
                                $idKelas = $siswaRef[$idSiswa]['kelas_id'] ?? null;
                                $namaKelas = $kelasRef[$idKelas]['nama_kelas'] ?? 'Tidak Diketahui';
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-6 text-body-md font-medium text-on-surface">
                                    {{ $absen['jam'] ?? '--:--' }}
                                </td>

                                <td class="p-6 text-body-md text-secondary">
                                    {{ $nisnSiswa }}
                                </td>

                                <td class="p-6 text-body-md font-bold text-on-surface">
                                    {{ $absen['nama'] ?? 'Tanpa Nama' }}
                                </td>

                                <td class="p-6 text-body-md text-secondary">
                                    {{ $namaKelas }}
                                </td>

                                <td class="p-6 text-center">
                                    @if(($absen['status'] ?? '') == 'Hadir')
                                        <span class="inline-flex items-center bg-green-50 text-green-700 border border-green-200 text-xs font-bold px-2.5 py-1 rounded-full">Hadir</span>
                                    @elseif(($absen['status'] ?? '') == 'Terlambat')
                                        <span class="inline-flex items-center bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-2.5 py-1 rounded-full">Terlambat</span>
                                    @elseif(($absen['status'] ?? '') == 'Sakit' || ($absen['status'] ?? '') == 'Izin')
                                        <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold px-2.5 py-1 rounded-full">{{ $absen['status'] }}</span>
                                    @else
                                        <span class="inline-flex items-center bg-gray-50 text-gray-600 border border-gray-200 text-xs font-bold px-2.5 py-1 rounded-full">{{ $absen['status'] ?? '-' }}</span>
                                    @endif
                                </td>

                                <td class="p-6 text-center">
                                    <form action="{{ route('absensi.update', ['tanggal' => $tanggalTerpilih, 'id' => $idSiswa]) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-body-sm rounded-lg bg-surface-container-lowest border border-outline-variant text-on-surface focus:ring-1 focus:ring-primary focus:border-primary p-1.5 outline-none transition-all cursor-pointer">
                                            <option value="Hadir" {{ ($absen['status'] ?? '') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="Terlambat" {{ ($absen['status'] ?? '') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                            <option value="Sakit" {{ ($absen['status'] ?? '') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="Izin" {{ ($absen['status'] ?? '') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="p-12 text-center text-body-md text-secondary bg-surface-container-lowest">
                                <span class="material-symbols-outlined text-4xl opacity-30 mb-2 block">folder_open</span>
                                Belum ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    @php
        $collectionAbsen = collect($absensiRef ?? []);
    @endphp
    <div class="flex justify-between items-center bg-surface-container-lowest p-6 rounded-xl shadow-[0px_-4px_12px_rgba(30,64,175,0.05)] sticky bottom-8 border border-outline-variant/30">
        <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-label-caps text-on-surface-variant font-bold">HADIR: {{ $collectionAbsen->where('status', 'Hadir')->count() }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <span class="text-label-caps text-on-surface-variant font-bold">TERLAMBAT: {{ $collectionAbsen->where('status', 'Terlambat')->count() }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-label-caps text-on-surface-variant font-bold">IZIN / SAKIT: {{ $collectionAbsen->whereIn('status', ['Izin', 'Sakit'])->count() }}</span>
            </div>
        </div>
        <div class="flex gap-4">
            <button onclick="window.print()" class="px-6 py-2.5 rounded-lg border border-primary text-primary font-bold text-body-md hover:bg-surface-container-low transition-all active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Cetak Rekap
            </button>
        </div>
    </div>
</x-app-layout>