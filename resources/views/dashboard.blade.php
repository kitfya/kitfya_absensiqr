<x-app-layout>
    <x-slot name="header">
        <!-- Page Header -->
        <header class="mb-gutter">
            <h2 class="text-headline-xl font-headline-xl text-on-background">
                Dashboard Overview
            </h2>
            <p class="text-body-lg text-on-surface-variant">
                Selamat datang kembali, berikut ringkasan kehadiran hari ini.
            </p>
        </header>
    </x-slot>

    <!-- Stats Cards Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-card-gap mb-gutter">
        <!-- Total Students -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-4">
                <span class="material-symbols-outlined p-2 bg-primary-fixed text-primary rounded-lg" data-icon="group">group</span>
                <span class="text-label-caps text-on-surface-variant">Total Siswa</span>
            </div>
            <div class="text-headline-xl font-headline-xl text-on-background">
                {{ number_format($totalSiswa) }}
            </div>
            <div class="mt-2 flex items-center text-label-caps text-green-600">
                <span class="material-symbols-outlined text-[16px] mr-1">trending_up</span>
                <span>+2% dari bulan lalu</span>
            </div>
        </div>

        <!-- Today's Attendance / Total Kelas -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-4">
                <span class="material-symbols-outlined p-2 bg-secondary-container text-secondary rounded-lg" data-icon="school">school</span>
                <span class="text-label-caps text-on-surface-variant">Total Kelas</span>
            </div>
            <div class="text-headline-xl font-headline-xl text-on-background">
                {{ $totalKelas }}
            </div>
            <div class="mt-2 flex items-center text-label-caps text-primary">
                <span>Ruang Kelas Aktif</span>
            </div>
        </div>

        <!-- Total Jurusan -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-4">
                <span class="material-symbols-outlined p-2 bg-tertiary-fixed text-tertiary rounded-lg" data-icon="domain">domain</span>
                <span class="text-label-caps text-on-surface-variant">Total Jurusan</span>
            </div>
            <div class="text-headline-xl font-headline-xl text-on-background">
                {{ $totalJurusan }}
            </div>
            <div class="mt-2 flex items-center text-label-caps text-on-surface-variant">
                <span>Kompetensi Keahlian</span>
            </div>
        </div>

        <!-- Absen Hari Ini -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-4">
                <span class="material-symbols-outlined p-2 bg-error-container text-error rounded-lg" data-icon="person_off">person_off</span>
                <span class="text-label-caps text-on-surface-variant">Absen Hari Ini</span>
            </div>
            <div class="text-headline-xl font-headline-xl text-error">
                {{ $totalAbsenHariIni }}
            </div>
            <div class="mt-2 flex items-center text-label-caps text-error">
                <span class="material-symbols-outlined text-[16px] mr-1">warning</span>
                <span>Membutuhkan tindak lanjut</span>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Area: Bento Style -->
    <div class="grid grid-cols-12 gap-card-gap">
        <!-- Weekly Attendance Trends Chart (KEMBALI KE DESIGN ASLI: CUSTOM BAR) -->
        <section class="col-span-12 lg:col-span-8 bg-surface-container-lowest p-gutter rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-title-md font-title-md text-on-background">
                        Tren Kehadiran Mingguan
                    </h3>
                    <p class="text-body-md text-on-surface-variant">
                        Data kehadiran per hari sekolah (7 Hari Terakhir)
                    </p>
                </div>
                <div class="flex gap-2">
                    <span class="text-xs bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-medium px-2.5 py-1 rounded self-center">Real-time Data</span>
                </div>
            </div>

            <div class="h-64 flex items-end justify-between gap-4 px-4">
    @foreach($chartLabels as $index => $label)
        @php
            $totalScan = $chartData[$index] ?? 0;
            $tinggiGrafik = $chartPercentages[$index] ?? 0;
        @endphp
        <div class="flex-1 flex flex-col items-center gap-3 h-full justify-end">
            <div class="w-full bg-primary-container/20 rounded-t-lg relative group overflow-hidden h-full flex items-end">
                
                <div class="chart-bar w-full bg-primary rounded-t-lg"
                     style="height: {{ $tinggiGrafik }}%"></div>
                
                <span class="absolute inset-x-0 bottom-1/2 translate-y-1/2 text-center text-[10px] sm:text-label-caps font-bold opacity-0 group-hover:opacity-100 transition-opacity text-primary bg-white/90 py-1 shadow-md rounded mx-1 whitespace-nowrap z-10">
                    {{ $totalScan }} Siswa ({{ $tinggiGrafik }}%)
                </span>
            </div>
            <span class="text-[10px] sm:text-label-caps text-on-surface-variant text-center whitespace-nowrap">{{ $label }}</span>
        </div>
    @endforeach
</div>
        </section>

        <!-- Recent Activity Section -->
        <section class="col-span-12 lg:col-span-4 flex flex-col gap-card-gap">
            <div class="bg-surface-container-lowest p-gutter rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 flex-1">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-title-md font-title-md text-on-background">
                        Aktivitas Terkini
                    </h3>
                    <a class="text-label-caps text-primary hover:underline" href="#">Lihat Semua</a>
                </div>
                <div class="space-y-6">
    @forelse($aktivitasTerkini as $aktivitas)
        <div class="flex gap-4">
            @if($aktivitas['status'] == 'Terlambat')
                <div class="w-10 h-10 rounded-full flex-shrink-0 bg-amber-100 flex items-center justify-center text-amber-700">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">schedule</span>
                </div>
            @elseif($aktivitas['status'] == 'Izin' || $aktivitas['status'] == 'Sakit')
                <div class="w-10 h-10 rounded-full flex-shrink-0 bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">mail</span>
                </div>
            @else
                <div class="w-10 h-10 rounded-full flex-shrink-0 bg-green-100 flex items-center justify-center text-green-700">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">check_circle</span>
                </div>
            @endif
            
            <div>
                <p class="text-body-md font-bold">
                    {{ $aktivitas['nama'] }} ({{ $aktivitas['kelas'] }})
                </p>
                <p class="text-body-md text-on-surface-variant">
                    Status: <span class="font-semibold">{{ $aktivitas['status'] }}</span> - {{ $aktivitas['keterangan'] }}
                </p>
                <p class="text-label-caps text-outline mt-1">{{ $aktivitas['jam'] }} WIB</p>
            </div>
        </div>
    @empty
        <div class="text-center py-6 text-on-surface-variant text-body-md">
            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">pending_actions</span>
            Belum ada aktivitas absensi masuk hari ini.
        </div>
    @endforelse
</div>
            </div>

            <!-- Call to Action / Quick Insight -->
            <div class="bg-primary text-on-primary p-6 rounded-xl shadow-lg relative overflow-hidden group">
                <div class="relative z-10">
                    <h4 class="text-title-md font-bold mb-2">Butuh Laporan Bulanan?</h4>
                    <p class="text-body-md mb-4 opacity-90">
                        Ekspor data kehadiran periode ini ke format PDF atau Excel dengan satu klik.
                    </p>
                    <button class="bg-white text-primary px-4 py-2 rounded-lg font-bold text-label-caps flex items-center gap-2 hover:bg-primary-fixed transition-colors">
                        <span class="material-symbols-outlined">download</span>
                        Unduh Laporan
                    </button>
                </div>
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-700"></div>
            </div>
        </section>
    </div>

    <!-- Secondary Section: Department Summary Table -->
    <section class="mt-gutter bg-surface-container-lowest rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-title-md font-title-md">Ringkasan per Departemen</h3>
            <div class="flex items-center gap-2 text-on-surface-variant">
                <span class="material-symbols-outlined">filter_list</span>
                <span class="text-label-caps">Urutkan: Kehadiran Terendah</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low text-label-caps text-on-surface-variant">
                    <tr>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4">Total Siswa</th>
                        <th class="px-6 py-4">Hadir</th>
                        <th class="px-6 py-4">Absen</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 text-data-table">
    @forelse($tabelDepartemen as $dept)
        <tr class="hover:bg-surface-container-low transition-colors text-on-background">
            <td class="px-6 py-4 font-bold">{{ $dept['nama'] }}</td>
            <td class="px-6 py-4">{{ number_format($dept['total']) }}</td>
            <td class="px-6 py-4 text-green-600 font-medium">{{ number_format($dept['hadir']) }}</td>
            <td class="px-6 py-4 text-error font-medium">{{ number_format($dept['absen']) }}</td>
            <td class="px-6 py-4">
                @if($dept['persentase'] >= 90)
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[12px] font-bold">
                        {{ $dept['persentase'] }}%
                    </span>
                @elseif($dept['persentase'] >= 75)
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[12px] font-bold">
                        {{ $dept['persentase'] }}%
                    </span>
                @else
                    <span class="px-3 py-1 bg-error-container text-error rounded-full text-[12px] font-bold">
                        {{ $dept['persentase'] }}%
                    </span>
                @endif
            </td>
            <td class="px-6 py-4 text-right">
                <a href="{{ route('akademik.index') }}" class="text-primary hover:text-tertiary hover:underline font-bold">
                    Detail
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-6 py-8 text-center text-on-surface-variant">
                Data Master Jurusan Tidak Ditemukan.
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </section>

    <!-- FAB for Quick Actions -->
    <button class="fixed bottom-gutter right-gutter w-14 h-14 bg-primary text-on-primary rounded-full shadow-xl hover:scale-110 active:scale-95 transition-all flex items-center justify-center group z-40">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">add</span>
        <div class="absolute right-16 bg-on-background text-surface px-4 py-2 rounded-lg text-label-caps opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
            Input Kehadiran Baru
        </div>
    </button>

    <!-- Animasi CSS Micro-interaction Asli Milikmu -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const bars = document.querySelectorAll(".chart-bar");
            bars.forEach((bar) => {
                const finalHeight = bar.style.height;
                bar.style.height = "0%";
                setTimeout(() => {
                    bar.style.height = finalHeight;
                }, 200);
            });
        });
    </script>
</x-app-layout>