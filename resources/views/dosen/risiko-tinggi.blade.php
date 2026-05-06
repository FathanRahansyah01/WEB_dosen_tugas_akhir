@extends('layouts.dosen')

@section('title', 'Mahasiswa Risiko Tinggi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Mahasiswa Risiko Tinggi</h1>
    <p class="text-gray-500 mt-1">Mahasiswa dengan tingkat stres <span class="text-red-600 font-semibold">High</span></p>
</div>

@if($highRiskStudents->count() > 0)
<div class="bg-red-50 border-2 border-red-200 rounded-xl overflow-hidden">
    <div class="px-6 py-4 bg-red-100 border-b border-red-200 flex items-center gap-2">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
        <span class="font-semibold text-red-800">{{ $highRiskStudents->count() }} mahasiswa memerlukan perhatian</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-red-100/50">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-red-700 uppercase text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-red-700 uppercase text-xs">NIM</th>
                    <th class="text-left px-6 py-3 font-medium text-red-700 uppercase text-xs">Nama</th>
                    <th class="text-left px-6 py-3 font-medium text-red-700 uppercase text-xs">Status</th>
                    <th class="text-left px-6 py-3 font-medium text-red-700 uppercase text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-red-100">
                @foreach($highRiskStudents as $student)
                <tr class="hover:bg-red-100/30">
                    <td class="px-6 py-4 text-red-900">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-mono text-red-900">{{ $student->nim }}</td>
                    <td class="px-6 py-4 font-semibold text-red-900">{{ $student->nama }}</td>
                    <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-200 text-red-800">⚠️ HIGH</span></td>
                    <td class="px-6 py-4">
                        <a href="{{ route('dosen.mahasiswa.detail', $student) }}" class="text-red-600 hover:text-red-800 font-medium text-sm">Lihat Detail →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
    <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <h3 class="text-lg font-semibold text-green-800">Semua Aman!</h3>
    <p class="text-green-600 mt-1">Tidak ada mahasiswa bimbingan dengan risiko tinggi saat ini.</p>
</div>
@endif
@endsection
