<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Management Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">Sukses!</span> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">➕ Tambah Kelas</h3>
                    
                    <form action="{{ route('kelas.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Contoh: XII RPL 1" required>
                        </div>

                        <div class="mb-4">
                            <label for="jurusan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @if(!empty($jurusanRef))
                                    @foreach($jurusanRef as $j_key => $jurusan)
                                        <option value="{{ $j_key }}">{{ $jurusan['nama_jurusan'] }} ({{ $jurusan['kode'] }})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition">
                            Simpan Data
                        </button>
                    </form>
                </div>

                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">📋 Daftar Kelas di Firebase</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Kelas</th>
                                    <th scope="col" class="px-6 py-3">Jurusan</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($kelasRef))
                                    @foreach($kelasRef as $key => $kelas)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                                {{ $kelas['nama_kelas'] }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                                @if(!empty($jurusanRef[$kelas['jurusan_id']]))
                                                    <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2.5 py-1 rounded">
                                                        {{ $jurusanRef[$kelas['jurusan_id']]['nama_jurusan'] }}
                                                    </span>
                                                @else
                                                    <span class="text-red-500 italic text-xs">Jurusan Terhapus</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center space-x-2">
                                                <button onclick="openEditModal('{{ $key }}', '{{ $kelas['nama_kelas'] }}', '{{ $kelas['jurusan_id'] }}')" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</button>
                                                
                                                <form action="{{ route('kelas.destroy', $key) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada data kelas.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full m-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">✏️ Edit Kelas</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="edit_nama_kelas" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Jurusan</label>
                    <select name="jurusan_id" id="edit_jurusan_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm" required>
                        @if(!empty($jurusanRef))
                            @foreach($jurusanRef as $j_key => $jurusan)
                                <option value="{{ $j_key }}">{{ $jurusan['nama_jurusan'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nama, jurusan_id) {
            document.getElementById('edit_nama_kelas').value = nama;
            document.getElementById('edit_jurusan_id').value = jurusan_id;
            document.getElementById('editForm').action = "/kelas/update/" + id;
            
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>