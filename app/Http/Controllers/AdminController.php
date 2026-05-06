<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\StressResult;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard admin - statistik umum.
     */
    public function dashboard()
    {
        $totalMahasiswa = Student::count();
        $totalDosen = User::where('role', 'dosen')->count();

        // Stress statistics
        $students = Student::with('stressResults')->get();
        $low = 0;
        $moderate = 0;
        $high = 0;

        foreach ($students as $student) {
            $latestStress = $student->stressResults->sortByDesc('created_at')->first();
            if ($latestStress) {
                match ($latestStress->level) {
                    'low' => $low++,
                    'moderate' => $moderate++,
                    'high' => $high++,
                };
            }
        }

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalDosen', 'low', 'moderate', 'high'
        ));
    }

    // ==========================================
    // CRUD MAHASISWA
    // ==========================================

    /**
     * List mahasiswa.
     */
    public function mahasiswaIndex()
    {
        $students = Student::with(['dosen', 'stressResults'])->get();
        return view('admin.mahasiswa.index', compact('students'));
    }

    /**
     * Form tambah mahasiswa.
     */
    public function mahasiswaCreate()
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('admin.mahasiswa.create', compact('dosens'));
    }

    /**
     * Simpan mahasiswa baru.
     */
    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students',
            'dosen_id' => 'required|exists:users,id',
        ]);

        Student::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'dosen_id' => $request->dosen_id,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Form edit mahasiswa.
     */
    public function mahasiswaEdit(Student $student)
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('admin.mahasiswa.edit', compact('student', 'dosens'));
    }

    /**
     * Update mahasiswa.
     */
    public function mahasiswaUpdate(Request $request, Student $student)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim,' . $student->id,
            'dosen_id' => 'required|exists:users,id',
        ]);

        $student->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'dosen_id' => $request->dosen_id,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Hapus mahasiswa.
     */
    public function mahasiswaDestroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }

    // ==========================================
    // CRUD DOSEN
    // ==========================================

    /**
     * List dosen.
     */
    public function dosenIndex()
    {
        $dosens = User::where('role', 'dosen')->withCount('students')->get();
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Form tambah dosen.
     */
    public function dosenCreate()
    {
        return view('admin.dosen.create');
    }

    /**
     * Simpan dosen baru.
     */
    public function dosenStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan.');
    }

    /**
     * Form edit dosen.
     */
    public function dosenEdit(User $user)
    {
        return view('admin.dosen.edit', compact('user'));
    }

    /**
     * Update dosen.
     */
    public function dosenUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Hapus dosen.
     */
    public function dosenDestroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil dihapus.');
    }
}
