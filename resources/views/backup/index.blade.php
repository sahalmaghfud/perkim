@extends('layouts.app')

@section('header-title', 'Backup System')
@section('content')
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Backup System</h2>

        {{-- Notifikasi --}}
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700">
                <span class="font-bold">Error:</span> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700">
                <span class="font-bold">Error:</span> Harap pilih setidaknya satu folder untuk di-backup.
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Backup Database --}}
            <div class="rounded-lg border border-gray-200 p-6 flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-database text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Backup Database</h3>
                        <p class="text-sm text-gray-500">
                            Unduh semua data dari database dalam format file .sql.
                        </p>
                    </div>
                </div>

                <a href="{{ route('backup.database') }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-xl shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition-all duration-200 ease-in-out">
                    <i class="fas fa-download mr-2"></i>
                    Backup & Unduh Database
                </a>
            </div>

            {{-- Backup Storage --}}
            <div class="rounded-lg border border-gray-200 p-6 flex flex-col justify-between">
                <form action="{{ route('backup.storage') }}" method="POST">
                    @csrf
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-teal-100 text-teal-600">
                            <i class="fas fa-folder-open text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Backup Storage</h3>
                            <p class="text-sm text-gray-500">
                                Pilih folder yang ingin di-backup dari <code>storage/app/public</code>.
                            </p>
                        </div>
                    </div>

                    {{-- Daftar Checkbox Folder --}}
                    <div class="mt-4 space-y-3 max-h-48 overflow-y-auto">
                        @forelse ($folders as $folder)
                            <label
                                class="flex items-center space-x-3 rounded-md border p-3 hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="selected_folders[]" value="{{ $folder }}"
                                    class="h-5 w-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                <span class="text-gray-700 font-medium">{{ $folder }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500 text-center p-4">Tidak ada folder ditemukan di
                                <code>storage/app/public</code>.
                            </p>
                        @endforelse
                    </div>

                    <button type="submit"
                        class="mt-5 w-full inline-flex items-center justify-center px-5 py-2.5 bg-teal-600 text-white font-medium rounded-xl shadow-md hover:bg-teal-700 focus:ring-2 focus:ring-teal-400 transition-all duration-200 ease-in-out">
                        <i class="fas fa-download mr-2"></i>
                        Backup & Unduh Folder Terpilih
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
