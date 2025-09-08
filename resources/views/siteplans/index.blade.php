@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Header Halaman --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Siteplan Perumahan</h2>
            <a href="{{ route('siteplans.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{-- Font Awesome icon, pastikan Anda telah menginstalnya --}}
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Siteplan Baru
            </a>
        </div>

        {{-- Notifikasi Sukses atau Error --}}
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        {{-- Card untuk Import dan Export --}}
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold text-lg text-gray-700">Import & Export Data</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('siteplans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                        <div class="md:col-span-5">
                            <label for="file" class="block text-sm font-medium text-gray-700">Pilih File Excel untuk
                                diimpor:</label>
                            <input type="file" name="file" id="file" required
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none
                                          file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Import
                            </button>
                        </div>
                        <div class="md:col-span-1 text-center hidden md:block">
                            <span class="text-gray-500">atau</span>
                        </div>
                        <div class="md:col-span-4">
                            <a href="{{ route('siteplans.export') }}"
                                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Export Data ke Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{-- Tabel Data --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold text-lg text-gray-700">Daftar Siteplan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Perumahan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                PT</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kecamatan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($siteplans as $siteplan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $loop->iteration + $siteplans->firstItem() - 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siteplan->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siteplan->nama_pt }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siteplan->kecamatan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siteplan->desa }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('siteplans.destroy', $siteplan->id) }}" method="POST"
                                        class="flex items-center space-x-2">
                                        <a href="{{ route('siteplans.show', $siteplan->id) }}"
                                            class="px-2.5 py-1.5 text-xs font-medium rounded text-white bg-cyan-600 hover:bg-cyan-700">Detail</a>

                                        <a href="{{ route('siteplans.edit', $siteplan->id) }}"
                                            class="px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700">Edit</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-2.5 py-1.5 text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link Paginasi --}}
            @if ($siteplans->hasPages())
                <div class="px-6 py-4">
                    {!! $siteplans->links() !!}
                </div>
            @endif
        </div>
    </div>
@endsection
