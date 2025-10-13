<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bidang;

return new class extends Migration {
    public function up(): void
    {
        DB::table('users')->insert([
            'name' => 'User Sekertariat',
            'email' => 'sekertariat@example.com',
            'password' => bcrypt('sekertariat123'),
            'role' => 'user',
            'bidang_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'sekertariat@example.com')->delete();
    }
};
