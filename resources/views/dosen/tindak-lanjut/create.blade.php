@extends('layouts.dosen')

@section('title', 'Tambah Tindak Lanjut')

@section('content')
<div class="mb-6">
    <a href="{{ route('dosen.tindak-lanjut.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Tambah Catatan Tindak Lanjut</h1>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 max-w-2xl">
    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('dosen.tindak-lanjut.store') }}">
        @csrf
        <div class="mb-4">
            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">Mahasiswa</label>
            <select id="student_id" name="student_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($students as $s)
                <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>{{ $s->nim }} - {{ $s->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label>
            <textarea id="note" name="note" rows="5" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none resize-y" placeholder="Tulis catatan tindak lanjut...">{{ old('note') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">Simpan</button>
            <a href="{{ route('dosen.tindak-lanjut.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
