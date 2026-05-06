<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StressResult;
use App\Models\FollowUp;

class DosenController extends Controller
{
    /**
     * Dashboard dosen - overview statistik mahasiswa bimbingan.
     */
    public function dashboard()
    {
        $dosenId = auth()->id();
        $students = Student::where('dosen_id', $dosenId)->with('stressResults')->get();

        $totalMahasiswa = $students->count();

        // Count students by their latest stress level
        $low = 0;
        $moderate = 0;
        $high = 0;
        $highStudents = collect();

        foreach ($students as $student) {
            $latestStress = $student->stressResults->sortByDesc('created_at')->first();
            if ($latestStress) {
                match ($latestStress->level) {
                    'low' => $low++,
                    'moderate' => $moderate++,
                    'high' => (function () use (&$high, &$highStudents, $student, $latestStress) {
                        $high++;
                        $highStudents->push($student);
                    })(),
                };
            }
        }

        return view('dosen.dashboard', compact(
            'totalMahasiswa', 'low', 'moderate', 'high', 'highStudents'
        ));
    }

    /**
     * Data mahasiswa bimbingan.
     */
    public function mahasiswa()
    {
        $students = Student::where('dosen_id', auth()->id())
            ->with('stressResults')
            ->get();

        return view('dosen.mahasiswa', compact('students'));
    }

    /**
     * Detail mahasiswa.
     */
    public function detailMahasiswa(Student $student)
    {
        // Pastikan student milik dosen ini
        if ($student->dosen_id !== auth()->id()) {
            abort(403);
        }

        $student->load('stressResults');

        return view('dosen.detail-mahasiswa', compact('student'));
    }

    /**
     * Monitoring stres - semua mahasiswa bimbingan dengan filter.
     */
    public function monitoring(Request $request)
    {
        $filter = $request->get('level');
        $dosenId = auth()->id();

        $query = Student::where('dosen_id', $dosenId)->with('stressResults');
        $students = $query->get();

        // Filter by latest stress level if specified
        if ($filter) {
            $students = $students->filter(function ($student) use ($filter) {
                $latest = $student->stressResults->sortByDesc('created_at')->first();
                return $latest && $latest->level === $filter;
            });
        }

        return view('dosen.monitoring', compact('students', 'filter'));
    }

    /**
     * Mahasiswa risiko tinggi.
     */
    public function risikoTinggi()
    {
        $dosenId = auth()->id();
        $students = Student::where('dosen_id', $dosenId)->with('stressResults')->get();

        $highRiskStudents = $students->filter(function ($student) {
            $latest = $student->stressResults->sortByDesc('created_at')->first();
            return $latest && $latest->level === 'high';
        });

        return view('dosen.risiko-tinggi', compact('highRiskStudents'));
    }

    /**
     * Tindak lanjut - list follow-ups.
     */
    public function tindakLanjut()
    {
        $followUps = FollowUp::where('dosen_id', auth()->id())
            ->with('student')
            ->latest()
            ->get();

        return view('dosen.tindak-lanjut.index', compact('followUps'));
    }

    /**
     * Form tambah tindak lanjut.
     */
    public function createTindakLanjut()
    {
        $students = Student::where('dosen_id', auth()->id())->get();

        return view('dosen.tindak-lanjut.create', compact('students'));
    }

    /**
     * Simpan tindak lanjut baru.
     */
    public function storeTindakLanjut(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'note' => 'required|string',
        ]);

        // Verifikasi student milik dosen ini
        $student = Student::where('id', $request->student_id)
            ->where('dosen_id', auth()->id())
            ->firstOrFail();

        FollowUp::create([
            'student_id' => $request->student_id,
            'dosen_id' => auth()->id(),
            'note' => $request->note,
        ]);

        return redirect()->route('dosen.tindak-lanjut.index')
            ->with('success', 'Catatan tindak lanjut berhasil ditambahkan.');
    }

    /**
     * Form edit tindak lanjut.
     */
    public function editTindakLanjut(FollowUp $followUp)
    {
        if ($followUp->dosen_id !== auth()->id()) {
            abort(403);
        }

        $students = Student::where('dosen_id', auth()->id())->get();

        return view('dosen.tindak-lanjut.edit', compact('followUp', 'students'));
    }

    /**
     * Update tindak lanjut.
     */
    public function updateTindakLanjut(Request $request, FollowUp $followUp)
    {
        if ($followUp->dosen_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'note' => 'required|string',
        ]);

        $followUp->update([
            'student_id' => $request->student_id,
            'note' => $request->note,
        ]);

        return redirect()->route('dosen.tindak-lanjut.index')
            ->with('success', 'Catatan tindak lanjut berhasil diperbarui.');
    }

    /**
     * Hapus tindak lanjut.
     */
    public function destroyTindakLanjut(FollowUp $followUp)
    {
        if ($followUp->dosen_id !== auth()->id()) {
            abort(403);
        }

        $followUp->delete();

        return redirect()->route('dosen.tindak-lanjut.index')
            ->with('success', 'Catatan tindak lanjut berhasil dihapus.');
    }
}
