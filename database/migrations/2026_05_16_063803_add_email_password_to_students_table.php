<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah kolom tanpa unique constraint dulu
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nim');
            $table->string('password')->nullable()->after('email');
        });

        // Isi email placeholder untuk data lama agar tidak duplikat
        $students = DB::table('students')->whereNull('email')->orWhere('email', '')->get();
        foreach ($students as $student) {
            DB::table('students')->where('id', $student->id)->update([
                'email' => $student->nim . '@student.local',
                'password' => Hash::make('password'),
            ]);
        }

        // Sekarang pasang unique constraint
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->unique()->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']);
        });
    }
};
