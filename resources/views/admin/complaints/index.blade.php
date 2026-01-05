{{-- resources/views/admin/complaints/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Pengaduan')
@section('page-title', 'Kelola Pengaduan')
@section('page-description', 'Semua pengaduan dari mahasiswa')

@section('content')

{{-- STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="rounded-xl border border-blue-500/20 bg-blue-900/20 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-300">Total</p>
                <p class="text-2xl font-bold text-white">{{ $statusCounts['total'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-blue-500/20 p-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>
    
    <div class="rounded-xl border border-yellow-500/20 bg-yellow-900/20 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-yellow-300">Pending</p>
                <p class="text-2xl font-bold text-white">{{ $statusCounts['pending'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-yellow-500/20 p-2">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
    
    <div class="rounded-xl border border-sky-500/20 bg-sky-900/20 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-sky-300">Diproses</p>
                <p class="text-2xl font-bold text-white">{{ $statusCounts['diproses'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-sky-500/20 p-2">
                <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
        </div>
    </div>
    
    <div class="rounded-xl border border-emerald-500/20 bg-emerald-900/20 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-emerald-300">Selesai</p>
                <p class="text-2xl font-bold text-white">{{ $statusCounts['selesai'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-emerald-500/20 p-2">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- HEADER & FILTER --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Daftar Pengaduan</h2>
        <p class="text-sm text-blue-300">Kelola semua pengaduan dari mahasiswa</p>
    </div>

    {{-- EXPORT BUTTON --}}
    <div class="flex gap-2">
        <button onclick="toggleExportModal()"
            class="rounded-xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/20 transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export
        </button>
    </div>
</div>

{{-- FILTER --}}
<form method="GET" class="mb-5 flex flex-wrap gap-3 items-center">
    <div class="flex items-center gap-2">
        <label class="text-sm text-blue-300">Status:</label>
        <select name="status"
            class="rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
            <option value="diproses" @selected(request('status') === 'diproses')>Diproses</option>
            <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
            <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
        </select>
    </div>

    <div class="flex items-center gap-2">
        <label class="text-sm text-blue-300">Kategori:</label>
        <select name="category"
            class="rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Semua Kategori</option>
            <option value="bullying" @selected(request('category') === 'bullying')>Bullying</option>
            <option value="lgbt" @selected(request('category') === 'lgbt')>LGBT</option>
            <option value="kekerasan" @selected(request('category') === 'kekerasan')>Kekerasan</option>
            <option value="akademik" @selected(request('category') === 'akademik')>Akademik</option>
            <option value="fasilitas" @selected(request('category') === 'fasilitas')>Fasilitas</option>
            <option value="lainnya" @selected(request('category') === 'lainnya')>Lainnya</option>
        </select>
    </div>

    <button type="submit"
        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
        Filter
    </button>

    @if(request()->has('status') || request()->has('category'))
    <a href="{{ route('admin.complaints.index') }}"
        class="rounded-lg border border-blue-400/30 px-4 py-2 text-sm font-semibold text-blue-300 hover:bg-blue-900/30 transition-colors">
        Reset
    </a>
    @endif
</form>

{{-- TABLE --}}
<div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-blue-400/30 text-blue-300">
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Mahasiswa</th>
                    <th class="py-3 px-4 text-left">Judul & Deskripsi</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Bukti</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($complaints as $complaint)
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

                <tr class="border-b border-blue-400/10 hover:bg-blue-900/30 transition-colors">
                    <td class="py-4 px-4">
                        <div class="text-sm text-blue-300 font-medium">
                            {{ $complaint->created_at->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-blue-400/70">{{ $complaint->created_at->format('H:i') }}</div>
                    </td>

                    <td class="py-4 px-4">
                        <div class="font-medium text-white">
                            {{ $complaint->user->name ?? 'N/A' }}
                        </div>
                        <div class="text-xs text-blue-400/70">
                            {{ $complaint->user->email ?? '' }}
                        </div>
                    </td>

                    <td class="py-4 px-4">
                        <div class="font-semibold text-white mb-1">
                            {{ $complaint->title }}
                        </div>
                        <div class="text-xs text-blue-300 line-clamp-2">
                            {{ $complaint->description }}
                        </div>

                        @if($status === 'ditolak' && $complaint->rejection_reason)
                        <div class="mt-2 text-xs text-red-200 bg-red-500/10 border border-red-500/20 rounded-lg p-2">
                            <strong class="font-medium">Alasan:</strong> {{ $complaint->rejection_reason }}
                        </div>
                        @endif
                    </td>

                    <td class="py-4 px-4">
                        <span class="inline-flex items-center rounded-full bg-blue-800/40 px-3 py-1 text-xs font-medium text-blue-200">
                            {{ ucfirst(str_replace('_',' ', $complaint->category)) }}
                        </span>
                    </td>

                    <td class="py-4 px-4">
                        @if($complaint->evidence_path)
                            <a href="{{ route('view.bukti', basename($complaint->evidence_path)) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1 text-sm text-blue-400 hover:text-blue-300 hover:underline transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>
                        @else
                            <span class="text-sm text-blue-400/50">-</span>
                        @endif
                    </td>

                    <td class="py-4 px-4">
                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium {{ $badge }}">
                            {{ strtoupper($status) }}
                        </span>
                    </td>

                    {{-- AKSI ADMIN --}}
                    <td class="py-4 px-4 text-right">
                        <div class="relative inline-block text-left">
                            <button type="button"
                                onclick="toggleDropdown({{ $complaint->id }})"
                                class="inline-flex items-center justify-center rounded-lg border border-blue-400/30 bg-blue-500/10 px-3 py-2 text-sm font-medium text-blue-200 hover:bg-blue-500/20 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-blue-900 transition-colors"
                                id="dropdown-button-{{ $complaint->id }}">
                                Aksi
                                <svg class="-mr-1 ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="dropdown-menu-{{ $complaint->id }}"
                                class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-xl border border-blue-400/20 bg-blue-950 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                <div class="py-1" role="menu">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-blue-200 hover:bg-blue-900 transition-colors"
                                        role="menuitem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.complaints.export.single', $complaint) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-emerald-200 hover:bg-blue-900 transition-colors"
                                        role="menuitem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export PDF
                                    </a>

                                    {{-- STATUS ACTIONS --}}
                                    @if($status !== 'ditolak')
                                    <form method="POST" action="{{ route('admin.complaints.update.status', $complaint) }}" class="border-t border-blue-400/10 pt-1">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @if($status === 'pending')
                                        <button type="submit" name="status" value="diproses"
                                            class="flex w-full items-center gap-2 px-4 py-2 text-sm text-sky-200 hover:bg-blue-900 transition-colors"
                                            onclick="return confirm('Ubah status menjadi Diproses?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Set Diproses
                                        </button>
                                        @endif

                                        @if($status === 'diproses')
                                        <button type="submit" name="status" value="selesai"
                                            class="flex w-full items-center gap-2 px-4 py-2 text-sm text-emerald-200 hover:bg-blue-900 transition-colors"
                                            onclick="return confirm('Tandai sebagai Selesai?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Set Selesai
                                        </button>
                                        @endif
                                    </form>
                                    @endif

                                    {{-- REJECT FORM --}}
                                    @if($status !== 'ditolak')
                                    <div class="border-t border-blue-400/10 pt-1">
                                        <button onclick="showRejectModal({{ $complaint->id }})"
                                            class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-200 hover:bg-blue-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Tolak
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-10 text-center">
                        <div class="text-blue-300">
                            <svg class="w-12 h-12 mx-auto mb-4 text-blue-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg font-medium mb-2">Tidak ada pengaduan</p>
                            <p class="text-sm text-blue-400/70">
                                @if(request()->has('status') || request()->has('category'))
                                    Tidak ada pengaduan dengan filter yang dipilih
                                @else
                                    Belum ada pengaduan yang dibuat
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($complaints->hasPages())
    <div class="mt-6 border-t border-blue-400/10 pt-6">
        {{ $complaints->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- MODAL TOLAK --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" onclick="hideRejectModal()"></div>
        
        <div class="relative w-full max-w-md rounded-2xl border border-red-500/20 bg-blue-950 p-6 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-4">Tolak Pengaduan</h3>
            
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-blue-300 mb-2">Alasan Penolakan</label>
                    <textarea name="rejection_reason" 
                        rows="3"
                        class="w-full rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Masukkan alasan penolakan..."
                        required></textarea>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button"
                        onclick="hideRejectModal()"
                        class="rounded-lg border border-blue-400/30 px-4 py-2 text-sm font-semibold text-blue-300 hover:bg-blue-900/30 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition-colors">
                        Tolak Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EXPORT --}}
<div id="exportModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" onclick="toggleExportModal()"></div>
        
        <div class="relative w-full max-w-md rounded-2xl border border-emerald-500/20 bg-blue-950 p-6 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-4">Export Laporan</h3>
            
            <form action="{{ route('admin.complaints.export.pdf') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-blue-300 mb-2">Status</label>
                        <select name="status"
                            class="w-full rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Dari Tanggal</label>
                            <input type="date" name="start_date"
                                class="w-full rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-300 mb-2">Sampai Tanggal</label>
                            <input type="date" name="end_date"
                                class="w-full rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                        onclick="toggleExportModal()"
                        class="rounded-lg border border-blue-400/30 px-4 py-2 text-sm font-semibold text-blue-300 hover:bg-blue-900/30 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition-colors">
                        Export PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleDropdown(id) {
    const menu = document.getElementById(`dropdown-menu-${id}`);
    const button = document.getElementById(`dropdown-button-${id}`);
    
    // Toggle visibility
    menu.classList.toggle('hidden');
    
    // Close other dropdowns
    document.querySelectorAll('[id^="dropdown-menu-"]').forEach(otherMenu => {
        if (otherMenu.id !== `dropdown-menu-${id}`) {
            otherMenu.classList.add('hidden');
        }
    });
    
    // Close dropdown when clicking outside
    const handleClickOutside = (event) => {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
            document.removeEventListener('click', handleClickOutside);
        }
    };
    
    // Add event listener for outside click
    setTimeout(() => {
        document.addEventListener('click', handleClickOutside);
    }, 0);
}

function showRejectModal(complaintId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/complaints/${complaintId}/reject`;
    
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function toggleExportModal() {
    const modal = document.getElementById('exportModal');
    modal.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
}
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush