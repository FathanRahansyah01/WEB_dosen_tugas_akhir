<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * GET /api/follow-ups?student_id={id}
     * Mengambil data tindak lanjut berdasarkan student_id.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
        ]);

        $followUps = FollowUp::with('dosen')
            ->where('student_id', $request->query('student_id'))
            ->latest()
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'note' => $item->note,
                'dosen' => [
                    'id' => $item->dosen->id,
                    'nama' => $item->dosen->name,
                ],
                'is_read' => (bool) $item->is_read,
                'created_at' => $item->created_at->toISOString(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $followUps,
        ]);
    }
}
