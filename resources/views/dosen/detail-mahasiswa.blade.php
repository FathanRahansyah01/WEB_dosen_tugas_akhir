@extends('layouts.dosen')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('dosen.mahasiswa') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 transition-colors mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Data Mahasiswa
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Detail Mahasiswa</h1>
</div>

{{-- Student Info Card --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <p class="text-sm text-gray-500">Nama</p>
            <p class="text-lg font-semibold text-gray-900">{{ $student->nama }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">NIM</p>
            <p class="text-lg font-semibold text-gray-900 font-mono">{{ $student->nim }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Status Stres Terakhir</p>
            @php
                $latestStress = $student->stressResults->sortByDesc('created_at')->first();
                $level = $latestStress ? $latestStress->level : null;
            @endphp
            @if($level)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1
                    {{ $level === 'low' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $level === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $level === 'high' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($level) }}
                </span>
            @else
                <span class="text-gray-400 text-sm mt-1 block">Belum ada data</span>
            @endif
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pengisian</p>
            <p class="text-lg font-semibold text-gray-900">{{ $student->stressResults->count() }} kali</p>
        </div>
    </div>
</div>

{{-- Stress History --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Riwayat Stres</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="table-stress-history">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">Tingkat Stres</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">Tanggal & Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($student->stressResults->sortByDesc('created_at') as $index => $result)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $result->level === 'low' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $result->level === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $result->level === 'high' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($result->level) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $result->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                        Belum ada riwayat stres.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
