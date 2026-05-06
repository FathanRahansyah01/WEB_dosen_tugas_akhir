@extends('layouts.admin')

@section('title', 'Data Dosen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Data Dosen</h1>
        <p class="text-gray-500 mt-1">Kelola data dosen</p>
    </div>
    <a href="{{ route('admin.dosen.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Dosen
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">No</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Nama</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Email</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Jumlah Mahasiswa</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500 uppercase text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dosens as $d)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium">{{ $d->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $d->email }}</td>
                    <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $d->students_count }} mahasiswa</span></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.dosen.edit', $d) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.dosen.destroy', $d) }}" onsubmit="return confirm('Hapus dosen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data dosen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
