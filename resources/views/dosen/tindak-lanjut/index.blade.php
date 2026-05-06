@extends('layouts.dosen')

@section('title', 'Tindak Lanjut')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tindak Lanjut</h1>
        <p class="text-gray-500 mt-1">Catatan follow-up mahasiswa bimbingan</p>
    </div>
    <a href="{{ route('dosen.tindak-lanjut.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Catatan
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Mahasiswa</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Catatan</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Tanggal</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($followUps as $fu)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $fu->student->nama }}</p>
                        <p class="text-xs text-gray-500 font-mono">{{ $fu->student->nim }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-700 max-w-xs truncate">{{ $fu->note }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $fu->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dosen.tindak-lanjut.edit', $fu) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('dosen.tindak-lanjut.destroy', $fu) }}" onsubmit="return confirm('Hapus catatan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada catatan tindak lanjut.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
