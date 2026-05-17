<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * GET /api/students
     * Mengambil semua data mahasiswa beserta dosen wali.
     */
    public function index(): JsonResponse
    {
        $students = Student::with('dosen')
            ->latest()
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'nama' => $s->nama,
                'nim' => $s->nim,
                'email' => $s->email,
                'dosen' => $s->dosen ? [
                    'id' => $s->dosen->id,
                    'nama' => $s->dosen->name,
                    'nip' => $s->dosen->nip,
                ] : null,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diambil',
            'data' => $students,
        ]);
    }
}
