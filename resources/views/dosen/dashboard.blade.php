@extends('layouts.dosen')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">Total Mahasiswa</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalMahasiswa }}</p>
                <p class="text-xs text-gray-400 mt-1">mahasiswa bimbingan</p>
            </div>
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">Stres Rendah</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $low }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $totalMahasiswa > 0 ? round(($low / $totalMahasiswa) * 100) : 0 }}% dari total</p>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">Stres Sedang</p>
                <p class="text-3xl font-extrabold text-amber-500 mt-2">{{ $moderate }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $totalMahasiswa > 0 ? round(($moderate / $totalMahasiswa) * 100) : 0 }}% dari total</p>
            </div>
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">Stres Tinggi</p>
                <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $high }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $totalMahasiswa > 0 ? round(($high / $totalMahasiswa) * 100) : 0 }}% dari total</p>
            </div>
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center group-hover:bg-rose-100 transition-colors">
                <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Chart Section --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm lg:col-span-1">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Distribusi Tingkat Stres</h3>
        <div class="flex justify-center">
            <canvas id="stressChart" width="220" height="220"></canvas>
        </div>
        <div class="mt-4 space-y-2">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-400 inline-block"></span> Rendah</div>
                <span class="font-semibold text-gray-700">{{ $low }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span> Sedang</div>
                <span class="font-semibold text-gray-700">{{ $moderate }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-rose-400 inline-block"></span> Tinggi</div>
                <span class="font-semibold text-gray-700">{{ $high }}</span>
            </div>
        </div>
    </div>

    {{-- Recent Follow-Ups --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Tindak Lanjut Terbaru</h3>
            <a href="{{ route('dosen.tindak-lanjut.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Semua →</a>
        </div>
        @if($recentFollowUps->count() > 0)
        <div class="space-y-3">
            @foreach($recentFollowUps as $fu)
            <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-sm font-bold text-indigo-600">{{ strtoupper(substr($fu->student->nama ?? '?', 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800">{{ $fu->student->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($fu->note, 80) }}</p>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $fu->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm text-gray-400">Belum ada tindak lanjut</p>
        </div>
        @endif
    </div>
</div>

{{-- Analytics Table: Semua Mahasiswa --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Mahasiswa Perlu Perhatian</h3>
                <p class="text-sm text-gray-400 mt-0.5">Daftar seluruh mahasiswa bimbingan dan tingkat stres terkini</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="searchStudent" placeholder="Cari mahasiswa..." class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all w-48">
                </div>
                <select id="filterLevel" class="px-3 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all">
                    <option value="all">Semua Level</option>
                    <option value="low">Rendah</option>
                    <option value="moderate">Sedang</option>
                    <option value="high">Tinggi</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" id="studentTable">
            <thead>
                <tr class="bg-gray-50/80">
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkat Stres</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Terakhir Mengisi</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $index => $student)
                @php
                    $latestStress = $student->stressResults->sortByDesc('created_at')->first();
                    $level = $latestStress ? $latestStress->level : null;
                    $lastFilled = $latestStress ? $latestStress->created_at->diffForHumans() : '-';
                @endphp
                <tr class="student-row hover:bg-indigo-50/40 transition-colors duration-150" data-level="{{ $level ?? 'none' }}" data-name="{{ strtolower($student->nama) }}" data-nim="{{ $student->nim }}">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $student->nim }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                {{ $level === 'high' ? 'bg-rose-100 text-rose-600' : ($level === 'moderate' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }}">
                                {{ strtoupper(substr($student->nama, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ $student->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($level === 'high')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Tinggi
                        </span>
                        @elseif($level === 'moderate')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sedang
                        </span>
                        @elseif($level === 'low')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Rendah
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-500 border border-gray-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Belum ada
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $lastFilled }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('dosen.mahasiswa.detail', $student) }}" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                        <p class="text-gray-500 font-medium">Belum ada data mahasiswa</p>
                        <p class="text-gray-400 text-sm mt-1">Mahasiswa bimbingan Anda akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    // Donut Chart
    const ctx = document.getElementById('stressChart');
    if (ctx) {
        const low = {{ $low }};
        const moderate = {{ $moderate }};
        const high = {{ $high }};
        const hasData = low + moderate + high > 0;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi'],
                datasets: [{
                    data: hasData ? [low, moderate, high] : [1],
                    backgroundColor: hasData ? ['#34d399', '#fbbf24', '#fb7185'] : ['#e5e7eb'],
                    borderWidth: 0,
                    borderRadius: hasData ? 4 : 0,
                    spacing: hasData ? 3 : 0,
                }]
            },
            options: {
                responsive: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: hasData }
                }
            }
        });
    }

    // Search & Filter
    const searchInput = document.getElementById('searchStudent');
    const filterSelect = document.getElementById('filterLevel');
    const rows = document.querySelectorAll('.student-row');

    function filterTable() {
        const query = searchInput.value.toLowerCase();
        const level = filterSelect.value;

        rows.forEach(row => {
            const name = row.dataset.name;
            const nim = row.dataset.nim;
            const rowLevel = row.dataset.level;

            const matchSearch = name.includes(query) || nim.includes(query);
            const matchLevel = level === 'all' || rowLevel === level;

            row.style.display = matchSearch && matchLevel ? '' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterSelect) filterSelect.addEventListener('change', filterTable);
</script>
@endpush
