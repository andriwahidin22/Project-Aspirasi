@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard')
@section('page-description', 'Sistem Informasi Pelayanan Advokasi')

@php
    $counts = $counts ?? [
        'total' => 0,
        'pending' => 0,
        'diproses' => 0,
        'selesai' => 0,
        'ditolak' => 0,
    ];

    $rejectedComplaints = $rejectedComplaints ?? collect();
    $ditolakCount = $counts['ditolak'] ?? 0;
@endphp

@section('content')
    <!-- PENJELASAN (TAB SUB MENU) -->
    <section class="rounded-2xl border border-blue-500/20 bg-gradient-to-r from-blue-900/40 via-blue-800/30 to-blue-900/40 p-6 shadow-lg mb-6">
        <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1 text-xs text-blue-300">
                    <span class="font-semibold">BEM</span>
                    <span class="text-blue-400/50">•</span>
                    <span class="font-semibold">Advokesma</span>
                    <span class="text-blue-400/50">•</span>
                    <span class="font-semibold">Aplikasi Advokasi</span>
                </div>

                <h1 class="mt-3 text-2xl font-bold text-white md:text-3xl">
                    Selamat Datang, {{ auth()->user()->email }}
                </h1>

                <p class="mt-2 text-sm leading-relaxed text-blue-100">
                    Gunakan sistem ini untuk menyampaikan pengaduan dan aspirasi kepada BEM UPI.
                </p>

                <!-- SUB MENU TAB -->
                <div class="mt-4 flex flex-wrap gap-2" id="info-tabs">
                    <button type="button" data-tab="bem"
                        class="tab-btn rounded-full border border-blue-500/40 bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400">
                        Tentang BEM
                    </button>

                    <button type="button" data-tab="advokesma"
                        class="tab-btn rounded-full border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm text-blue-200 hover:bg-blue-500/20">
                        Tentang Advokesma
                    </button>

                    <button type="button" data-tab="aplikasi"
                        class="tab-btn rounded-full border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm text-blue-200 hover:bg-blue-500/20">
                        Tentang Aplikasi
                    </button>
                </div>

                <!-- PANEL TAB -->
                <div class="mt-4">
                    <!-- BEM -->
                    <div id="tab-bem" class="tab-panel rounded-xl border border-blue-400/30 bg-blue-900/20 p-5">
                        <div class="text-sm font-semibold text-white">BEM (Badan Eksekutif Mahasiswa)</div>
                        <p class="mt-2 text-sm leading-relaxed text-blue-200">
                            BEM adalah singkatan dari Badan Eksekutif Mahasiswa, yaitu organisasi mahasiswa intra kampus yang
                            merupakan lembaga Eksekutif di tingkat perguruan tinggi.
                        </p>
                    </div>

                    <!-- ADVOKESMA -->
                    <div id="tab-advokesma" class="tab-panel hidden rounded-xl border border-blue-400/30 bg-blue-900/20 p-5">
                        <div class="text-sm font-semibold text-white">
                            Kementerian Advokasi Kesejahteraan Mahasiswa (Advokesma)
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-blue-200">
                            Advokesma bertanggung jawab untuk menjembatani kebutuhan mahasiswa dengan kebijakan kampus dalam
                            menyampaikan aspirasi serta membantu penyelesaian permasalahan.
                        </p>
                    </div>

                    <!-- APLIKASI -->
                    <div id="tab-aplikasi" class="tab-panel hidden rounded-xl border border-blue-400/30 bg-blue-900/20 p-5">
                        <div class="text-sm font-semibold text-white">
                            Aplikasi Advokasi BEM
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-blue-200">
                            Aplikasi ini mempermudah mahasiswa menyampaikan keluhan/aspirasi terkait akademik maupun non-akademik,
                            serta memantau status pengaduan secara jelas (Pending, Diproses, Selesai, atau Ditolak).
                        </p>
                    </div>
                </div>

                <!-- ALUR STATUS -->
                <div class="mt-4 text-sm text-blue-200">
                    <span class="font-semibold text-white">Alur Status:</span>
                    <span class="ml-2 inline-flex flex-wrap items-center gap-2">
                        <span class="rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1 text-xs text-blue-200">Pending</span>
                        <span class="text-blue-400/50">→</span>
                        <span class="rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1 text-xs text-blue-200">Diproses</span>
                        <span class="text-blue-400/50">→</span>
                        <span class="rounded-full border border-blue-400/30 bg-blue-500/10 px-3 py-1 text-xs text-blue-200">Selesai</span>
                        <span class="text-blue-400/50">/</span>
                        <span class="rounded-full border border-red-500/30 bg-red-600/10 px-3 py-1 text-xs text-red-200">Ditolak</span>
                    </span>
                </div>
            </div>

            <!-- BOX KANAN -->
            <div class="flex flex-wrap gap-2 md:justify-end">
                <div class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-3 text-sm text-blue-200">
                    Privasi Terjaga
                    <div class="text-xs text-blue-300/60">Identitas pelapor tidak ditampilkan publik</div>
                </div>
                <div class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-3 text-sm text-blue-200">
                    Bukti Pendukung
                    <div class="text-xs text-blue-300/60">JPG/PNG/PDF maksimal 10MB</div>
                </div>
            </div>
        </div>
    </section>

    <!-- RINGKASAN PENGADUAN -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-white">Ringkasan Pengaduan Anda</h2>
            <p class="text-sm text-blue-300">Statistik pengaduan yang telah Anda kirim</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('mahasiswa.complaints.create') }}"
               class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400">
                Buat Pengaduan
            </a>
            <a href="{{ route('mahasiswa.complaints.index') }}"
               class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20">
                Lihat Riwayat
            </a>
        </div>
    </div>

    <!-- Cards ringkasan -->
    <div class="grid gap-4 md:grid-cols-4 mb-6">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-blue-300">Total</h3>
                <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-white">{{ $counts['total'] ?? 0 }}</p>
            <p class="text-xs text-blue-300/60 mt-1">Semua pengaduan</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-blue-300">Pending</h3>
                <div class="h-2 w-2 rounded-full bg-amber-500"></div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $counts['pending'] ?? 0 }}</p>
            <p class="text-xs text-blue-300/60 mt-1">Menunggu tindakan</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-blue-300">Diproses</h3>
                <div class="h-2 w-2 rounded-full bg-blue-500"></div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $counts['diproses'] ?? 0 }}</p>
            <p class="text-xs text-blue-300/60 mt-1">Sedang diproses</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-blue-300">Selesai</h3>
                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $counts['selesai'] ?? 0 }}</p>
            <p class="text-xs text-blue-300/60 mt-1">Telah diselesaikan</p>
        </div>
    </div>

    <!-- KOTAK PENGADUAN DITOLAK -->
    @if($ditolakCount > 0)
    <div class="rounded-2xl border border-red-500/30 bg-red-600/10 p-6 shadow-lg mb-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div>
                <div class="text-sm text-red-200">Info Penolakan</div>
                <h3 class="text-xl font-bold text-white">Pengaduan Ditolak & Alasannya</h3>
                <p class="mt-1 text-sm text-red-200/80">
                    Pengaduan yang ditolak oleh Admin BEM beserta alasan penolakan
                </p>
            </div>

            <a href="{{ route('mahasiswa.complaints.index') }}"
               class="rounded-xl border border-red-500/30 bg-red-600/10 px-4 py-2 text-sm font-semibold text-red-200 hover:bg-red-600/20">
                Lihat Semua
            </a>
        </div>

        <div class="space-y-3">
            @forelse($rejectedComplaints as $c)
                <div class="rounded-2xl border border-red-500/20 bg-red-900/20 p-4 transition-all duration-300 hover:border-red-400/30 hover:bg-red-900/30">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                        <div class="font-semibold text-white">{{ $c->title ?? '-' }}</div>
                        <div class="text-xs text-red-300/70">{{ $c->updated_at?->format('d/m/Y H:i') ?? '-' }}</div>
                    </div>

                    <div class="text-sm text-red-200">
                        <span class="font-semibold">Alasan ditolak:</span>
                        {{ !empty($c->rejection_reason) ? $c->rejection_reason : 'Tidak ada alasan (silakan hubungi Admin).' }}
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-blue-400/30 bg-blue-900/20 p-4 text-sm text-blue-300">
                    Tidak ada pengaduan yang ditolak
                </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Tips -->
    <div class="rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-900/30 to-blue-800/20 p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-white mb-4">Tips Pengaduan Efektif</h3>
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-blue-400/30 bg-blue-900/20 p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="h-8 w-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                        <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h4 class="font-medium text-white">Judul Jelas</h4>
                </div>
                <p class="text-sm text-blue-300">Isi judul singkat dan jelas agar mudah dipahami</p>
            </div>
            
            <div class="rounded-xl border border-blue-400/30 bg-blue-900/20 p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="h-8 w-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                        <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="font-medium text-white">Detail Kronologi</h4>
                </div>
                <p class="text-sm text-blue-300">Jelaskan kejadian secara detail dengan waktu dan tempat</p>
            </div>
            
            <div class="rounded-xl border border-blue-400/30 bg-blue-900/20 p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="h-8 w-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                        <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-medium text-white">Upload Bukti</h4>
                </div>
                <p class="text-sm text-blue-300">Lampirkan bukti pendukung untuk memperkuat laporan</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const root = document.getElementById('info-tabs');
            if (!root) return;

            const btns = root.querySelectorAll('.tab-btn');
            const panels = {
                bem: document.getElementById('tab-bem'),
                advokesma: document.getElementById('tab-advokesma'),
                aplikasi: document.getElementById('tab-aplikasi'),
            };

            function setActive(key) {
                Object.values(panels).forEach(p => p && p.classList.add('hidden'));
                panels[key] && panels[key].classList.remove('hidden');

                btns.forEach(b => {
                    const active = b.dataset.tab === key;

                    // reset
                    b.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'font-semibold', 'border-blue-500/40', 'shadow-md');
                    b.classList.add('bg-blue-500/10', 'text-blue-200', 'hover:bg-blue-500/20', 'border-blue-400/30');

                    if (active) {
                        b.classList.remove('bg-blue-500/10', 'text-blue-200', 'hover:bg-blue-500/20', 'border-blue-400/30');
                        b.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'font-semibold', 'border-blue-500/40', 'shadow-md');
                    }
                });
            }

            btns.forEach(b => b.addEventListener('click', () => setActive(b.dataset.tab)));
            setActive('bem');
        })();
    </script>
@endpush