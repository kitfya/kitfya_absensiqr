<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end mb-8">
            <div>
                <nav class="flex items-center gap-2 text-label-caps text-secondary mb-2">
                    <span>Pengaturan</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary font-bold">Jadwal Absensi</span>
                </nav>
                <h2 class="text-headline-xl font-headline-xl text-on-background">Pengaturan Jadwal Absensi</h2>
                <p class="text-body-md text-secondary mt-1">Konfigurasikan batas waktu jam masuk, toleransi keterlambatan, dan jam pulang siswa.</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 max-w-md mx-auto">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="py-4">
        <div class="max-w-md mx-auto">
            <div class="bg-surface-container-lowest overflow-hidden shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 rounded-xl p-8 relative">
                
                <div class="w-16 h-16 bg-primary-fixed text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-[32px]">more_time</span>
                </div>

                <form action="{{ route('absensi.jadwal.simpan') }}" method="POST" class="space-y-5 text-left">
                    @csrf
                    
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Mulai Absen (Pagi)</label>
                        <div class="relative">
                            <input type="time" name="mulai" value="{{ $jadwal['mulai'] ?? '06:30' }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2.5 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Batas Tepat Waktu (Toleransi)</label>
                        <div class="relative">
                            <input type="time" name="batas_hadir" value="{{ $jadwal['batas_hadir'] ?? '07:15' }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2.5 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                        </div>
                        <p class="text-[11px] text-amber-600 font-medium mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            Lewat jam ini siswa otomatis tercatat "Terlambat".
                        </p>
                    </div>

                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Selesai Absen (Sore)</label>
                        <div class="relative">
                            <input type="time" name="selesai" value="{{ $jadwal['selesai'] ?? '16:00' }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-2.5 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all active:scale-95 shadow-md">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Pengaturan Jadwal
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>