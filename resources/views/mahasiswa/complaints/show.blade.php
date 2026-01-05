@extends('layouts.mahasiswa')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')
@section('page-description', 'Informasi lengkap pengaduan Anda')

@section('content')
{{-- HEADER --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Detail Pengaduan</h2>
        <p class="text-sm text-blue-300">Informasi lengkap pengaduan Anda</p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('mahasiswa.complaints.index') }}"
            class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20 transition-colors">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </span>
        </a>

        @if($complaint->status === 'pending')
        <a href="{{ route('mahasiswa.complaints.edit', $complaint) }}"
            class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20 transition-colors">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </span>
        </a>
        @endif
    </div>
</div>

{{-- COMPLAINT DETAIL CARD --}}
<div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-6">
    {{-- STATUS BADGE --}}
    @php
        $status = $complaint->status;
        $badge = match($status) {
            'pending' => 'bg-yellow-500/20 text-yellow-200 border-yellow-500/30',
            'diproses' => 'bg-sky-500/20 text-sky-200 border-sky-500/30',
            'selesai' => 'bg-emerald-500/20 text-emerald-200 border-emerald-500/30',
            'ditolak' => 'bg-red-500/20 text-red-200 border-red-500/30',
            default => 'bg-blue-500/20 text-blue-200 border-blue-500/30',
        };
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-6 border-b border-blue-400/20">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-400/70">ID Pengaduan</div>
                <div class="text-lg font-bold text-white">#{{ $complaint->id }}</div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-medium {{ $badge }}">
                {{ strtoupper($status) }}
            </span>
        </div>
    </div>

    {{-- COMPLAINT INFO GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- TANGGAL DIBUAT --}}
        <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-4">
            <div class="flex items-center gap-2 text-blue-300 text-xs mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Tanggal Dibuat
            </div>
            <div class="text-white font-medium">
                {{ $complaint->created_at->format('d/m/Y') }}
            </div>
            <div class="text-xs text-blue-400/70">
                {{ $complaint->created_at->format('H:i') }} WIB
            </div>
        </div>

        {{-- KATEGORI --}}
        <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-4">
            <div class="flex items-center gap-2 text-blue-300 text-xs mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kategori
            </div>
            <div class="text-white font-medium">
                {{ ucfirst(str_replace('_', ' ', $complaint->category)) }}
            </div>
        </div>

        {{-- TERAKHIR UPDATE --}}
        <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-4">
            <div class="flex items-center gap-2 text-blue-300 text-xs mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Terakhir Update
            </div>
            <div class="text-white font-medium">
                {{ $complaint->updated_at->format('d/m/Y') }}
            </div>
            <div class="text-xs text-blue-400/70">
                {{ $complaint->updated_at->format('H:i') }} WIB
            </div>
        </div>

        {{-- BUKTI --}}
        <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-4">
            <div class="flex items-center gap-2 text-blue-300 text-xs mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Bukti
            </div>
            @if($complaint->evidence_path)
                <a href="{{ route('view.bukti', basename($complaint->evidence_path)) }}"
                   target="_blank"
                   class="text-blue-300 hover:text-blue-200 hover:underline text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Bukti
                </a>
            @else
                <span class="text-blue-400/50 text-sm">Tidak ada</span>
            @endif
        </div>
    </div>

    {{-- JUDUL & DESKRIPSI --}}
    <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-6 mb-6">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Judul & Deskripsi
        </h3>

        <div class="mb-4">
            <div class="text-xs text-blue-400/70 mb-1">Judul Pengaduan</div>
            <div class="text-xl font-semibold text-white">{{ $complaint->title }}</div>
        </div>

        <div>
            <div class="text-xs text-blue-400/70 mb-2">Deskripsi / Kronologi</div>
            <div class="text-blue-100 leading-relaxed whitespace-pre-line bg-blue-900/20 rounded-lg p-4">
                {{ $complaint->description }}
            </div>
        </div>
    </div>

    {{-- ALASAN PENOLAKAN (JIKA DITOLAK) --}}
    @if($status === 'ditolak' && $complaint->rejection_reason)
    <div class="rounded-xl bg-red-500/10 border border-red-500/30 p-6 mb-6">
        <h3 class="text-lg font-bold text-red-200 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Alasan Penolakan
        </h3>
        <div class="text-red-100 leading-relaxed bg-red-500/10 rounded-lg p-4 border border-red-500/20">
            {{ $complaint->rejection_reason }}
        </div>
    </div>
    @endif

    {{-- TIMELINE STATUS --}}
    <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-6">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Riwayat Status
        </h3>

        <div class="space-y-4">
            {{-- PENDING --}}
            <div class="flex items-start gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-yellow-500/20 border-2 border-yellow-500/50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="w-0.5 h-full bg-blue-400/20 mt-1"></div>
                </div>
                <div class="flex-1 pb-4">
                    <div class="text-sm font-medium text-yellow-200">Menunggu Verifikasi</div>
                    <div class="text-xs text-blue-400/70">{{ $complaint->created_at->format('d/m/Y H:i') }} WIB</div>
                </div>
            </div>

            {{-- DIPROSES (jika status >= diproses) --}}
            @if(in_array($status, ['diproses', 'selesai', 'ditolak']))
            <div class="flex items-start gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-sky-500/20 border-2 border-sky-500/50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="w-0.5 h-full bg-blue-400/20 mt-1"></div>
                </div>
                <div class="flex-1 pb-4">
                    <div class="text-sm font-medium text-sky-200">Sedang Diproses</div>
                    <div class="text-xs text-blue-400/70">Pengaduan sedang dalam penanganan</div>
                </div>
            </div>
            @endif

            {{-- SELESAI ATAU DITOLAK --}}
            @if($status === 'selesai')
            <div class="flex items-start gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 border-2 border-emerald-500/50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-emerald-200">Selesai</div>
                    <div class="text-xs text-blue-400/70">Pengaduan telah diselesaikan</div>
                </div>
            </div>
            @elseif($status === 'ditolak')
            <div class="flex items-start gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-red-500/20 border-2 border-red-500/50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-red-200">Ditolak</div>
                    <div class="text-xs text-blue-400/70">Pengaduan tidak dapat diproses lebih lanjut</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="mt-6 pt-6 border-t border-blue-400/10 flex flex-wrap gap-3 justify-end">
        <a href="{{ route('mahasiswa.complaints.index') }}"
            class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20 transition-colors">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </span>
        </a>

        @if($complaint->status === 'pending')
        <a href="{{ route('mahasiswa.complaints.edit', $complaint) }}"
            class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:opacity-90 transition-opacity">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Pengaduan
            </span>
        </a>
        @endif
    </div>
</div>
@endsection

