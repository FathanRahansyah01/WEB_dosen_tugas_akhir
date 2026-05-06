@extends('layouts.dosen')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Data Mahasiswa</h1>
    <p class="text-gray-500 mt-1">Daftar mahasiswa bimbingan Anda</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="table-mahasiswa">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">NIM</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">Nama</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">Tingkat Stres</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase tracking-wider text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $index => $student)
                @php
                    $latestStress = $student->stressResults->sortByDesc('created_at')->first();
                    $level = $latestStress ? $latestStress->level : null;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-mono text-gray-900">{{ $student->nim }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $student->nama }}</td>
                    <td class="px-6 py-4">
                        @if($level)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $level === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $level === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $level === 'high' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($level) }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">Belum ada data</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('dosen.mahasiswa.detail', $student) }}"
                           class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        Belum ada data mahasiswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
