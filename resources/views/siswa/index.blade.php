<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end mb-8">
            <div>
                <nav class="flex items-center gap-2 text-label-caps text-secondary mb-2">
                    <span>Manajemen</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary font-bold">Daftar Siswa</span>
                </nav>
                <h2 class="text-headline-xl font-headline-xl text-on-background">Manajemen Siswa</h2>
                <p class="text-body-md text-secondary mt-1">Kelola data akademik dan informasi personal siswa di sini.</p>
            </div>
            <button onclick="openSiswaModal('tambah')" class="bg-primary hover:bg-primary-container text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all active:scale-95 shadow-lg shadow-primary/10">
                <span class="material-symbols-outlined">add</span>
                Tambah Siswa
            </button>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-body-md font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-8">
        <div class="bg-white p-6 rounded-xl custom-shadow border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
            </div>
            <div>
                <p class="text-label-caps text-secondary uppercase">Total Siswa</p>
                <p class="text-headline-lg font-headline-lg">{{ !empty($siswaRef) ? number_format(count($siswaRef)) : 0 }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl custom-shadow border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">boy</span>
            </div>
            <div>
                <p class="text-label-caps text-secondary uppercase">Laki-laki</p>
                <p class="text-headline-lg font-headline-lg">{{ !empty($siswaRef) ? collect($siswaRef)->where('jenis_kelamin', 'L')->count() : 0 }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl custom-shadow border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                <span class="material-symbols-outlined">girl</span>
            </div>
            <div>
                <p class="text-label-caps text-secondary uppercase">Perempuan</p>
                <p class="text-headline-lg font-headline-lg">{{ !empty($siswaRef) ? collect($siswaRef)->where('jenis_kelamin', 'P')->count() : 0 }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl custom-shadow border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-label-caps text-secondary uppercase">Status Database</p>
                <p class="text-headline-lg font-headline-lg text-green-600">Aktif</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl custom-shadow border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <select id="filterKelas" class="appearance-none bg-surface-container-low border border-outline-variant rounded-lg pl-4 pr-10 py-2 text-body-md focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="">Semua Kelas</option>
                        @if(!empty($kelasRef))
                            @foreach($kelasRef as $k_id => $kelas)
                                <option value="{{ $k_id }}">{{ $kelas['nama_kelas'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                </div>
                <div class="relative">
                    <select id="filterGender" class="appearance-none bg-surface-container-low border border-outline-variant rounded-lg pl-4 pr-10 py-2 text-body-md focus:outline-none focus:ring-2 focus:ring-primary/20">
                        <option value="">Gender</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container transition-all" title="Download Excel">
                    <span class="material-symbols-outlined text-on-surface-variant">download</span>
                </button>
                <button class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container transition-all" title="Cetak Data">
                    <span class="material-symbols-outlined text-on-surface-variant">print</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant">NISN</th>
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant">NAMA SISWA</th>
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant">KELAS / JURUSAN</th>
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant">GENDER</th>
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant">STATUS</th>
                        <th class="px-6 py-4 text-label-caps text-secondary font-bold border-b border-outline-variant text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($siswaRef as $key => $siswa)
                        @php
                            $initSiswa = implode('', array_map(function($v) { return $v[0] ?? ''; }, explode(' ', $siswa['nama'])));
                            $initSiswa = strtoupper(substr($initSiswa, 0, 2));
                            
                            $kelasData = $kelasRef[$siswa['kelas_id']] ?? null;
                            $jurusanKode = $kelasData && !empty($jurusanRef[$kelasData['jurusan_id']]) ? $jurusanRef[$kelasData['jurusan_id']]['kode'] : '???';
                        @endphp
                        <tr class="hover:bg-surface-container-low data-row-siswa" data-kelas="{{ $siswa['kelas_id'] }}" data-gender="{{ $siswa['jenis_kelamin'] }}">
                            <td class="px-6 py-4 text-body-md font-mono font-medium text-secondary">#{{ $siswa['nisn'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-xs">{{ $initSiswa }}</div>
                                    <span class="text-body-md font-bold text-on-surface">{{ $siswa['nama'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-body-md">
                                @if($kelasData)
                                    <span class="bg-blue-50 text-primary border border-primary/10 px-2.5 py-1 rounded-md font-medium">
                                        {{ $kelasData['nama_kelas'] }} - {{ $jurusanKode }}
                                    </span>
                                @else
                                    <span class="text-error italic text-xs bg-red-50 px-2 py-1 rounded">Rombel Terhapus</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-body-md">
                                {{ $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-green-100 text-green-700">Aktif</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openSiswaModal('edit', '{{ $key }}', '{{ $siswa['nisn'] }}', '{{ $siswa['nama'] }}', '{{ $siswa['jenis_kelamin'] }}', '{{ $siswa['kelas_id'] }}')" class="p-2 text-secondary hover:bg-secondary/5 rounded-lg transition-all" title="Edit Data">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <form action="{{ route('siswa.destroy', $key) }}" method="POST" class="inline" onsubmit="return confirm('Hapus permanen data siswa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-error hover:bg-error/5 rounded-lg transition-all" title="Hapus">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-on-surface-variant">Belum ada data siswa terdaftar di sistem.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-outline-variant flex items-center justify-between">
            <span class="text-body-md text-secondary">Menampilkan 1-{{ count($siswaRef ?? []) }} siswa</span>
        </div>
    </div>

    <div id="modalSiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-outline-variant transform scale-95 transition-transform duration-300">
            <h3 id="modalSiswaTitle" class="text-title-md font-bold text-on-surface mb-4">Tambah Master Siswa</h3>
            <form id="modalSiswaForm" action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div id="modalSiswaMethod"></div>
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Nomor NISN</label>
                        <input type="text" id="inputNisn" name="nisn" required placeholder="Contoh: 00543211" class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Nama Lengkap Siswa</label>
                        <input type="text" id="inputNama" name="nama" required placeholder="Nama Lengkap" class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Jenis Kelamin</label>
                        <select id="selectJk" name="jenis_kelamin" required class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none">
                            <option value="">-- Pilih Rumpun Gender --</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-caps text-on-surface-variant mb-1">Kamar/Ruang Kelas</label>
                        <select id="selectKelas" name="kelas_id" required class="w-full border border-outline-variant rounded-lg p-2.5 text-body-md focus:ring-2 focus:ring-primary/20 focus:outline-none">
                            <option value="">-- Pilih Kelas --</option>
                            @if(!empty($kelasRef))
                                @foreach($kelasRef as $k_key => $kelas)
                                    @php 
                                        $jNama = !empty($jurusanRef[$kelas['jurusan_id']]) ? $jurusanRef[$kelas['jurusan_id']]['kode'] : 'No-Program';
                                    @endphp
                                    <option value="{{ $k_key }}">{{ $kelas['nama_kelas'] }} ({{ $jNama }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeSiswaModal()" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg font-semibold hover:bg-surface-container-low transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-colors">Simpan Informasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modalS = document.getElementById('modalSiswa');
        
        function openSiswaModal(tipe, id = '', nisn = '', nama = '', jk = '', kelas_id = '') {
            modalS.classList.remove('hidden');
            setTimeout(() => { 
                modalS.classList.add('opacity-100'); 
                modalS.firstElementChild.classList.remove('scale-95'); 
            }, 50);
            
            if(tipe === 'edit') {
                document.getElementById('modalSiswaTitle').innerText = '✏️ Edit Data Siswa';
                document.getElementById('modalSiswaForm').action = "/siswa/update/" + id;
                document.getElementById('modalSiswaMethod').innerHTML = `@method('PUT')`;
                document.getElementById('inputNisn').value = nisn;
                document.getElementById('inputNama').value = nama;
                document.getElementById('selectJk').value = jk;
                document.getElementById('selectKelas').value = kelas_id;
            } else {
                document.getElementById('modalSiswaTitle').innerText = '➕ Tambah Data Siswa';
                document.getElementById('modalSiswaForm').action = "{{ route('siswa.store') }}";
                document.getElementById('modalSiswaMethod').innerHTML = '';
                document.getElementById('modalSiswaForm').reset();
            }
        }

        function closeModalSiswa() {
            modalS.classList.remove('opacity-100');
            modalS.firstElementChild.classList.add('scale-95');
            setTimeout(() => modalS.classList.add('hidden'), 300);
        }

        // Fitur Live Filtering Instan (Tanpa Reload Halaman) untuk dropdown Kelas & Gender
        const fKelas = document.getElementById('filterKelas');
        const fGender = document.getElementById('filterGender');
        const rows = document.querySelectorAll('.data-row-siswa');

        function filterTable() {
            const valKelas = fKelas.value;
            const valGender = fGender.value;

            rows.forEach(row => {
                const matchKelas = !valKelas || row.getAttribute('data-kelas') === valKelas;
                const matchGender = !valGender || row.getAttribute('data-gender') === valGender;

                if(matchKelas && matchGender) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        fKelas.addEventListener('change', filterTable);
        fGender.addEventListener('change', filterTable);
    </script>
</x-app-layout>