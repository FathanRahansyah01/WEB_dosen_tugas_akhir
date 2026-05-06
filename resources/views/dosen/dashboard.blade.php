@extends('layouts.dosen')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Total Mahasiswa --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMahasiswa }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Low Stress --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Stres Rendah</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $low }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Moderate Stress --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Stres Sedang</p>
                <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $moderate }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- High Stress --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Stres Tinggi</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $high }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- High Risk Students Highlight --}}
@if($highStudents->count() > 0)
<div class="bg-red-50 border border-red-200 rounded-xl p-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
        <h2 class="text-lg font-semibold text-red-800">⚠️ Mahasiswa Risiko Tinggi</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="table-high-risk">
            <thead>
                <tr class="text-left text-red-700">
                    <th class="pb-2 font-medium">NIM</th>
                    <th class="pb-2 font-medium">Nama</th>
                    <th class="pb-2 font-medium">Status</th>
                    <th class="pb-2 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-red-100">
                @foreach($highStudents as $student)
                <tr>
                    <td class="py-2 text-red-900 font-mono">{{ $student->nim }}</td>
                    <td class="py-2 text-red-900 font-medium">{{ $student->nama }}</td>
                    <td class="py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            High
                        </span>
                    </td>
                    <td class="py-2">
                        <a href="{{ route('dosen.mahasiswa.detail', $student) }}" class="text-red-600 hover:text-red-800 font-medium text-xs">
                            Lihat Detail →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
    <svg class="w-12 h-12 text-green-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-green-800 font-medium">Tidak ada mahasiswa dengan risiko tinggi saat ini.</p>
    <p class="text-green-600 text-sm mt-1">Semua mahasiswa bimbingan dalam kondisi baik.</p>
</div>
@endif
@endsection
