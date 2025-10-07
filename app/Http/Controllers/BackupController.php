<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

use ZipArchive;

class BackupController extends Controller
{
    protected $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups/');
        if (!File::isDirectory($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true, true);
        }
    }

    /**
     * Menampilkan halaman GUI untuk backup dengan daftar folder storage.
     */
    public function index()
    {
        // Ambil semua direktori di dalam storage/app/public
        $directories = File::directories(storage_path('app/public'));

        // Ambil hanya nama foldernya saja
        $folders = array_map('basename', $directories);

        return view('backup.index', ['folders' => $folders]);
    }

    /**
     * Membuat backup database dan mengirimkannya sebagai download.
     */
    public function backupDatabase()
    {
        $database = env('DB_DATABASE');
        $filename = "backup_{$database}_" . date('Y-m-d_H-i-s') . ".sql";
        $path = storage_path("app/backup/{$filename}");

        // Pastikan folder backup ada
        if (!File::exists(storage_path('app/backup'))) {
            File::makeDirectory(storage_path('app/backup'), 0755, true);
        }

        // Ambil semua tabel
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $database;

        $sql = "-- Backup database: {$database}\n";
        $sql .= "-- Dibuat pada: " . now() . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // Dapatkan perintah CREATE TABLE
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable . ";\n\n";

            // Ambil semua data
            $rows = DB::table($tableName)->get();

            if ($rows->count() > 0) {
                $columns = array_map(function ($col) {
                    return "`$col`";
                }, array_keys((array) $rows[0]));

                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        if ($value === null)
                            return "NULL";
                        return "'" . addslashes($value) . "'";
                    }, array_values((array) $row));

                    $sql .= "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        // Simpan file .sql
        File::put($path, $sql);

        // Kirim ke browser untuk didownload
        return Response::download($path)->deleteFileAfterSend(true);
    }

    /**
     * Membuat backup storage (file zip) berdasarkan folder yang dipilih.
     */
    public function backupStorage(Request $request)
    {
        // Validasi input
        $request->validate([
            'selected_folders' => 'required|array|min:1',
            'selected_folders.*' => 'string', // Pastikan setiap item adalah string
        ]);

        $selectedFolders = $request->input('selected_folders');

        try {
            $zipFileName = 'storage-backup-' . date('Y-m-d_H-i-s') . '.zip';
            $zipFilePath = $this->backupPath . $zipFileName;

            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                throw new \Exception('Tidak dapat membuat file zip.');
            }

            // Loop melalui folder yang dipilih dan tambahkan isinya ke zip
            foreach ($selectedFolders as $folderName) {
                $sourceFolder = storage_path('app/public/' . $folderName);

                // Pastikan folder benar-benar ada untuk keamanan
                if (!File::isDirectory($sourceFolder)) {
                    continue;
                }

                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($sourceFolder),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        // Buat path relatif di dalam zip agar nama folder utamanya ikut
                        $relativePath = $folderName . '/' . substr($filePath, strlen($sourceFolder) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }

            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat backup storage: ' . $e->getMessage());
        }
    }
}
