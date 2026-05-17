<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthMobileController extends Controller
{
    /**
     * POST /api/register
     * Registrasi mahasiswa baru dari Flutter.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:students,nim',
            'email' => 'required|string|email|max:255|unique:students,email',
            'password' => 'required|string|min:6|confirmed',
            'nip_dosen' => 'required|string',
        ]);

        // Cari dosen berdasarkan NIP dan pastikan role = dosen
        $dosen = \App\Models\User::where('nip', $validated['nip_dosen'])
            ->where('role', 'dosen')
            ->first();

        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'NIP dosen tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $student = Student::create([
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'dosen_id' => $dosen->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'data' => [
                'id' => $student->id,
                'nama' => $student->nama,
                'nim' => $student->nim,
                'email' => $student->email,
                'dosen_id' => $student->dosen_id,
                'created_at' => $student->created_at->toISOString(),
            ],
        ], 201);
    }

    /**
     * POST /api/login
     * Login mahasiswa dari Flutter.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'id' => $student->id,
                'nama' => $student->nama,
                'nim' => $student->nim,
                'email' => $student->email,
                'dosen_id' => $student->dosen_id,
            ],
        ]);
    }
}
