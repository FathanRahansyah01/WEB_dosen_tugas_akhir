<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StressResult;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StressResultController extends Controller
{
    /**
     * GET /api/stress-results
     * Mengambil semua data stress results dengan informasi mahasiswa.
     *
     * Query Parameters (opsional):
     *   - nama: string (pencarian LIKE berdasarkan nama mahasiswa)
     *   - tingkat_stres: Low | Moderate | High
     */
    public function index(Request $request): JsonResponse
    {
        $query = StressResult::with('student');

        // Filter berdasarkan nama mahasiswa (LIKE search)
        if ($request->filled('nama')) {
            $nama = $request->query('nama');
            $query->whereHas('student', function ($q) use ($nama) {
                $q->where('nama', 'LIKE', '%' . $nama . '%');
            });
        }

        // Filter berdasarkan tingkat stres
        if ($request->filled('tingkat_stres')) {
            $level = strtolower($request->query('tingkat_stres'));

            if (!in_array($level, ['low', 'moderate', 'high'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter tingkat_stres tidak valid. Gunakan: Low, Moderate, atau High',
                    'data' => [],
                ], 422);
            }

            $query->where('level', $level);
        }

        $results = $query->latest()
            ->get()
            ->map(fn ($item) => $this->formatResponse($item));

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $results,
        ]);
    }

    /**
     * GET /api/stress-results/{id}
     * Mengambil 1 data stress result berdasarkan ID.
     */
    public function show(string $id): JsonResponse
    {
        $result = StressResult::with('student')->find($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $this->formatResponse($result),
        ]);
    }

    /**
     * POST /api/stress-results
     * Menambahkan data stress result baru.
     *
     * Request body:
     *   - nim (required): NIM mahasiswa yang sudah terdaftar
     *   - tingkat_stres (required): Low / Moderate / High
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nim' => 'required|string',
            'tingkat_stres' => 'required|string|in:Low,Moderate,High,low,moderate,high',
        ]);

        // Cari student berdasarkan NIM
        $student = Student::where('nim', $validated['nim'])->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa dengan NIM tersebut tidak ditemukan',
                'data' => null,
            ], 404);
        }

        // Simpan stress result
        $result = StressResult::create([
            'student_id' => $student->id,
            'level' => strtolower($validated['tingkat_stres']),
        ]);

        $result->load('student');

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $this->formatResponse($result),
        ], 201);
    }

    /**
     * PUT /api/stress-results/{id}
     * Mengupdate data stress result.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $result = StressResult::find($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validated = $request->validate([
            'tingkat_stres' => 'required|string|in:Low,Moderate,High,low,moderate,high',
        ]);

        $result->update([
            'level' => strtolower($validated['tingkat_stres']),
        ]);

        $result->load('student');

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $this->formatResponse($result),
        ]);
    }

    /**
     * DELETE /api/stress-results/{id}
     * Menghapus data stress result.
     */
    public function destroy(string $id): JsonResponse
    {
        $result = StressResult::find($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $result->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => null,
        ]);
    }

    /**
     * Format stress result ke response JSON yang flat & clean.
     */
    private function formatResponse(StressResult $item): array
    {
        $levelMap = [
            'low' => 'Low',
            'moderate' => 'Moderate',
            'high' => 'High',
        ];

        return [
            'id' => $item->id,
            'nama_mahasiswa' => $item->student->nama ?? '-',
            'nim' => $item->student->nim ?? '-',
            'tingkat_stres' => $levelMap[$item->level] ?? $item->level,
            'created_at' => $item->created_at->toISOString(),
            'updated_at' => $item->updated_at->toISOString(),
        ];
    }
}
