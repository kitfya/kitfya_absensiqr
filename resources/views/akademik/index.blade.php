<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end mb-8">
            <div>
                <nav class="flex text-label-caps font-label-caps text-on-surface-variant mb-2">
                    <span>Manajemen Akademik</span>
                    <span class="mx-2">/</span>
                    <span class="text-primary">Jurusan & Kelas</span>
                </nav>
                <h2 class="text-headline-xl font-headline-xl text-on-surface">Manajemen Akademik</h2>
            </div>
            <div class="flex gap-3">
                <button onclick="openModalJurusan('tambah')" class="flex items-center gap-2 bg-primary text-on-primary px-6 py-2.5 rounded-lg font-semibold hover:opacity-90 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Jurusan</span>
                </button>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <section class="mb-12">
        <div class="flex items-center gap-2 mb-6">
            <span class="material-symbols-outlined text-primary">domain</span>
            <h3 class="text-title-md font-title-md text-on-surface">Manajemen Jurusan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-card-gap">
            @forelse($jurusanRef as $idJurusan => $jurusan)
                @php
                    // Hitung jumlah kelas yang berelasi dengan jurusan ini
                    $jumlahKelas = collect($kelasRef)->where('jurusan_id', $idJurusan)->count();
                    $namaJurusan = $jurusan['nama_jurusan'] ?? '-';
                    $kodeJurusan = $jurusan['kode'] ?? '-';
                @endphp
                <div class="bg-white p-6 rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] border border-outline-variant/20 hover:border-primary/40 transition-all group relative">
                    
                    <div class="absolute top-4 right-4 flex gap-1">
                        <button onclick="openModalJurusan('edit', '{{ $idJurusan }}', '{{ $namaJurusan }}', '{{ $kodeJurusan }}')" class="text-primary hover:bg-surface-container p-1.5 rounded transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <form action="{{ route('jurusan.destroy', $idJurusan) }}" method="POST" onsubmit="return confirm('Hapus jurusan ini beserta data di dalamnya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-error hover:bg-error-container/20 p-1.5 rounded transition-colors">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>

                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-primary-fixed rounded-lg flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[28px]">science</span>
                        </div>
                        <span class="text-label-caps font-label-caps bg-green-100 text-green-700 px-3 py-1 rounded-full mr-14">{{ $kodeJurusan }}</span>
                    </div>
                    <h4 class="text-headline-lg font-headline-lg mb-2">{{ $namaJurusan }}</h4>
                    <p class="text-body-md font-body-md text-on-surface-variant mb-6">Kompetensi keahlian rumpun pendidikan program {{ $namaJurusan }}.</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                        <span class="text-label-caps text-on-surface-variant uppercase">Status: Aktif</span>
                        <span class="text-body-md font-semibold text-primary">{{ $jumlahKelas }} Kelas</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white p-8 text-center rounded-xl border border-outline-variant/30 text-on-surface-variant">
                    Belum ada data master jurusan di Firebase database.
                </div>
            @endforelse
        </div>
    </section>

    <section>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">school</span>
                <h3 class="text-title-md font-title-md text-on-surface">Manajemen Kelas</h3>
            </div>
            <button onclick="openModalKelas('tambah')" class="flex items-center gap-2 border border-primary text-primary px-4 py-2 rounded-lg font-semibold hover:bg-primary/5 transition-all">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Kelas</span>
            </button>
        </div>
        <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(30,64,175,0.05)] overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Nama Kelas</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Jurusan Rumpun</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider text-center">Estimasi Siswa</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($kelasRef as $idKelas => $kelas)
                        @php
                            $idJurusanKelas = $kelas['jurusan_id'] ?? '';
                            $namaJurusanInduk = $jurusanRef[$idJurusanKelas]['nama_jurusan'] ?? 'Tidak Diketahui';
                            $totalSiswaKelas = collect($siswaRef)->where('kelas_id', $idKelas)->count();
                        @endphp
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-body-md font-bold text-on-surface">{{ $kelas['nama_kelas'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-body-md text-on-surface-variant">{{ $namaJurusanInduk }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-body-md font-semibold">{{ $totalSiswaKelas }} Siswa</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="openModalKelas('edit', '{{ $idKelas }}', '{{ $kelas['nama_kelas'] }}', '{{ $idJurusanKelas }}')" class="text-primary hover:text-tertiary transition-colors mr-3">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <form action="{{ route('kelas.destroy', $idKelas) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus ruang kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-error hover:opacity-70 transition-colors">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-on-surface-variant">Tidak ada data kelas yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div id="modalJurusan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-outline-variant transform scale-95 transition-transform duration-300">
            <h3 id="modalJurusanTitle" class="text-title-md font-bold text-on-surface mb-4">Tambah Data Jurusan</h3>
            <form id="modalJurusanForm" action="{{ route('jurusan.store') }}" method="POST">
                @csrf
                <div id="modalJurusanMethod"></div>
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Nama Jurusan</label>
                        <input type="text" id="inputNamaJurusan" name="nama_jurusan" required class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Kode / Singkatan</label>
                        <input type="text" id="inputKodeJurusan" name="kode" required placeholder="Contoh: IPA, RMP" class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none"/>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModalJurusan()" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg font-semibold hover:bg-surface-container-low transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-colors">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalKelas" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-outline-variant transform scale-95 transition-transform duration-300">
            <h3 id="modalKelasTitle" class="text-title-md font-bold text-on-surface mb-4">Tambah Ruang Kelas</h3>
            <form id="modalKelasForm" action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div id="modalKelasMethod"></div>
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Nama Kelas</label>
                        <input type="text" id="inputNamaKelas" name="nama_kelas" required placeholder="Contoh: X IPA 1" class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Pilih Jurusan Induk</label>
                        <select id="selectJurusanKelas" name="jurusan_id" required class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none">
                            <option value="">-- Pilih Rumpun Jurusan --</option>
                            @foreach($jurusanRef as $keyJ => $j)
                                <option value="{{ $keyJ }}">{{ $j['nama_jurusan'] ?? $keyJ }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModalKelas()" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg font-semibold hover:bg-surface-container-low transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-colors">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // --- LOGIK MODAL JURUSAN ---
        const modalJ = document.getElementById('modalJurusan');
        function openModalJurusan(tipe, id = '', nama = '', kode = '') {
            modalJ.classList.remove('hidden');
            setTimeout(() => { modalJ.classList.add('opacity-100'); modalJ.firstElementChild.classList.remove('scale-95'); }, 50);
            
            if(tipe === 'edit') {
                document.getElementById('modalJurusanTitle').innerText = 'Ubah Data Jurusan';
                document.getElementById('modalJurusanForm').action = `/jurusan/update/${id}`;
                document.getElementById('modalJurusanMethod').innerHTML = `@method('PUT')`;
                document.getElementById('inputNamaJurusan').value = nama;
                document.getElementById('inputKodeJurusan').value = kode;
            } else {
                document.getElementById('modalJurusanTitle').innerText = 'Tambah Data Jurusan';
                document.getElementById('modalJurusanForm').action = "{{ route('jurusan.store') }}";
                document.getElementById('modalJurusanMethod').innerHTML = '';
                document.getElementById('modalJurusanForm').reset();
            }
        }
        function closeModalJurusan() {
            modalJ.classList.remove('opacity-100');
            modalJ.firstElementChild.classList.add('scale-95');
            setTimeout(() => modalJ.add('hidden'), 300);
        }

        // --- LOGIK MODAL KELAS ---
        const modalK = document.getElementById('modalKelas');
        function openModalKelas(tipe, id = '', nama = '', jurusanId = '') {
            modalK.classList.remove('hidden');
            setTimeout(() => { modalK.classList.add('opacity-100'); modalK.firstElementChild.classList.remove('scale-95'); }, 50);
            
            if(tipe === 'edit') {
                document.getElementById('modalKelasTitle').innerText = 'Ubah Informasi Kelas';
                document.getElementById('modalKelasForm').action = `/kelas/update/${id}`;
                document.getElementById('modalKelasMethod').innerHTML = `@method('PUT')`;
                document.getElementById('inputNamaKelas').value = nama;
                document.getElementById('selectJurusanKelas').value = jurusanId;
            } else {
                document.getElementById('modalKelasTitle').innerText = 'Tambah Ruang Kelas Baru';
                document.getElementById('modalKelasForm').action = "{{ route('kelas.store') }}";
                document.getElementById('modalKelasMethod').innerHTML = '';
                document.getElementById('modalKelasForm').reset();
            }
        }
        function closeModalKelas() {
            modalK.classList.remove('opacity-100');
            modalK.firstElementChild.classList.add('scale-95');
            setTimeout(() => modalK.classList.add('hidden'), 300);
        }
    </script>
</x-app-layout>