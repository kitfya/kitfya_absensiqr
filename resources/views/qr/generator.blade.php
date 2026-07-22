<x-app-layout>
    <x-slot name="header">
        <!-- Page Header Section -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <nav class="flex items-center gap-2 text-label-caps text-secondary mb-2">
                    <span>Absensi</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary font-bold">QR Generator</span>
                </nav>
                <h2 class="text-headline-xl font-headline-xl text-on-background">Live QR Code Generator</h2>
                <p class="text-body-md text-secondary mt-1">Gunakan halaman ini di proyektor atau layar depan kelas agar siswa dapat melakukan scan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto">
            <div class="bg-surface-container-lowest overflow-hidden shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/30 rounded-xl p-8 text-center relative group">
                
                <!-- Dekorasi Atas Menggunakan Ikon Sinkron -->
                <div class="w-16 h-16 bg-primary-fixed text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[32px]">qr_code_scanner</span>
                </div>

                <h3 class="text-headline-lg font-headline-lg text-on-surface mb-2">Silakan Scan untuk Absensi</h3>
                <p class="text-body-md text-error font-semibold mb-6 flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    QR Code berubah otomatis setiap 20 detik!
                </p>

                <!-- Box QR Container -->
                <div class="flex justify-center items-center bg-white p-4 rounded-xl border border-outline-variant shadow-inner mx-auto w-72 h-72" id="qrcode">
                    <div class="text-secondary flex flex-col items-center gap-2 text-body-md">
                        <span class="material-symbols-outlined animate-spin">sync</span>
                        Memuat QR Code...
                    </div>
                </div>

                <!-- Status Waktu Pembaruan -->
                <div class="mt-6 text-label-caps text-on-surface-variant flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    Terakhir diperbarui pada: <span id="updated-time" class="font-bold text-primary ml-1">--:--:--</span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-surface-container rounded-full h-2 mt-4 overflow-hidden">
                    <div id="progress-bar" class="bg-primary h-2 rounded-full transition-all duration-1000 ease-linear" style="width: 100%"></div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script QR Code Generator Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        let timeLeft = 20; 
        const progressBar = document.getElementById('progress-bar');
        let qrContainer = document.getElementById("qrcode");

        function fetchNewQr() {
            fetch("{{ route('api.qr.generate') }}?t=" + new Date().getTime())
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    qrContainer.innerHTML = "";
                    
                    new QRCode(qrContainer, {
                        text: data.code,
                        width: 250,
                        height: 250,
                        colorDark : "#0b1c30",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });

                    document.getElementById('updated-time').innerText = data.updated_at;
                    timeLeft = 20; // reset kembali ke 20 detik
                } else {
                    qrContainer.innerHTML = `
                        <div class="text-error flex flex-col items-center gap-2 text-center p-4">
                            <span class="material-symbols-outlined text-4xl text-amber-500 animate-pulse">lock</span>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">${data.message}</p>
                        </div>
                    `;
                    document.getElementById('updated-time').innerText = data.updated_at;
                    timeLeft = 10; 
                }
            })
            .catch(error => {
                console.error('Gagal mengambil QR baru:', error);
                qrContainer.innerHTML = `
                    <div class="text-error flex flex-col items-center gap-1 text-center p-4">
                        <span class="material-symbols-outlined text-3xl">cloud_off</span>
                        <p class="text-xs font-bold">Koneksi Gagal</p>
                    </div>
                `;
            });
        }

        // Timer Hitung Mundur Progress Bar
        setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                let percentage = (timeLeft / 20) * 100; 
                progressBar.style.width = percentage + '%';
            } else {
                fetchNewQr();
            }
        }, 1000);

        window.onload = function() {
            fetchNewQr();
        };
    </script>
</x-app-layout>