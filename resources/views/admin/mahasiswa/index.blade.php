@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Data Mahasiswa</h1>
        <p class="text-gray-500 mt-1">Kelola data mahasiswa</p>
    </div>
    <a href="{{ route('admin.mahasiswa.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Mahasiswa
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">NIM</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Nama</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Dosen Pembimbing</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Stres</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $s)
                @php $ls = $s->stressResults->sortByDesc('created_at')->first(); @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-mono">{{ $s->nim }}</td>
                    <td class="px-6 py-4 font-medium">{{ $s->nama }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $s->dosen->name ?? '-' }}
                        @if($s->dosen && $s->dosen->nip)
                        <span class="block text-xs text-gray-400 font-mono">NIP: {{ $s->dosen->nip }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($ls)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ls->level === 'low' ? 'bg-green-100 text-green-800' : ($ls->level === 'moderate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($ls->level) }}</span>
                        @else <span class="text-gray-400 text-xs">-</span> @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.mahasiswa.edit', $s) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.mahasiswa.destroy', $s) }}" onsubmit="return confirm('Hapus mahasiswa ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
