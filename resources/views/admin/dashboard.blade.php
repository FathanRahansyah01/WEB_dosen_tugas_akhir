@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMahasiswa }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Dosen</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalDosen }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm sm:col-span-2 lg:col-span-1">
        <p class="text-sm font-medium text-gray-500 mb-3">Statistik Stres</p>
        <div class="flex items-center gap-4">
            <div class="text-center"><p class="text-2xl font-bold text-green-600">{{ $low }}</p><p class="text-xs text-gray-500">Low</p></div>
            <div class="text-center"><p class="text-2xl font-bold text-yellow-600">{{ $moderate }}</p><p class="text-xs text-gray-500">Moderate</p></div>
            <div class="text-center"><p class="text-2xl font-bold text-red-600">{{ $high }}</p><p class="text-xs text-gray-500">High</p></div>
        </div>
    </div>
</div>
@endsection
