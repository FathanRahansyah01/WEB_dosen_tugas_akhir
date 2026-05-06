@extends('layouts.dosen')

@section('title', 'Monitoring Stres')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Monitoring Stres</h1>
    <p class="text-gray-500 mt-1">Data keseluruhan tingkat stres mahasiswa</p>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm font-medium text-gray-600">Filter:</span>
        <a href="{{ route('dosen.monitoring') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ !$filter ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
        <a href="{{ route('dosen.monitoring', ['level' => 'low']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $filter === 'low' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">🟢 Low</a>
        <a href="{{ route('dosen.monitoring', ['level' => 'moderate']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $filter === 'moderate' ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' }}">🟡 Moderate</a>
        <a href="{{ route('dosen.monitoring', ['level' => 'high']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $filter === 'high' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">🔴 High</a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">NIM</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Nama</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Tingkat Stres</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Terakhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                @php $ls = $student->stressResults->sortByDesc('created_at')->first(); @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-mono">{{ $student->nim }}</td>
                    <td class="px-6 py-4 font-medium">{{ $student->nama }}</td>
                    <td class="px-6 py-4">
                        @if($ls)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ls->level === 'low' ? 'bg-green-100 text-green-800' : ($ls->level === 'moderate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($ls->level) }}</span>
                        @else <span class="text-gray-400 text-xs">-</span> @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $ls ? $ls->created_at->format('d M Y, H:i') : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
