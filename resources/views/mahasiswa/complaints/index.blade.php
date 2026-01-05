@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengaduan')
@section('page-title', 'Riwayat Pengaduan')
@section('page-description', 'Semua pengaduan yang telah Anda kirim')

@section('content')

{{-- HEADER --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Riwayat Pengaduan</h2>
        <p class="text-sm text-blue-300">Semua pengaduan yang telah Anda kirim</p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('mahasiswa.dashboard') }}"
            class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20 transition-colors">
            Dashboard
        </a>

        <a href="{{ route('mahasiswa.complaints.create') }}"
            class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:opacity-90 transition-opacity">
            Buat Baru
        </a>
    </div>
</div>

{{-- FILTER --}}
<form method="GET" class="mb-5 flex flex-wrap gap-3 items-center">
    <div class="flex items-center gap-2">
        <label class="text-sm text-blue-300">Status:</label>
        <select name="status"
            class="rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Semua Status</option>
            @foreach(['pending','diproses','selesai','ditolak'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center gap-2">
        <label class="text-sm text-blue-300">Kategori:</label>
        <select name="category"
            class="rounded-lg bg-blue-900/40 border border-blue-400/30 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Semua Kategori</option>
            @foreach(['bullying','lgbt','kekerasan_seksual','cat_calling','akademik','fasilitas','lainnya'] as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>
                    {{ ucfirst(str_replace('_',' ', $c)) }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit"
        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
        Filter
    </button>

    @if(request()->has('status') || request()->has('category'))
    <a href="{{ route('mahasiswa.complaints.index') }}"
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

                    {{-- AKSI DROPDOWN YANG RAPI --}}
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
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl border border-blue-400/20 bg-blue-950 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                                style="min-width: 160px;">
                                <div class="py-1" role="menu">
                                    <a href="{{ route('mahasiswa.complaints.show', $complaint) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-blue-200 hover:bg-blue-900 transition-colors"
                                        role="menuitem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Detail
                                    </a>

                                    @if($status === 'pending')
                                    <a href="{{ route('mahasiswa.complaints.edit', $complaint) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-blue-200 hover:bg-blue-900 transition-colors"
                                        role="menuitem">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- FORM HAPUS --}}
                                    <form method="POST" 
                                          action="{{ route('mahasiswa.complaints.destroy', $complaint) }}" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?\\n\\nSetelah dihapus, data tidak dapat dikembalikan.')"
                                          class="border-t border-blue-400/10 pt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-200 hover:bg-blue-900 transition-colors"
                                                role="menuitem">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center">
                        <div class="text-blue-300">
                            <svg class="w-12 h-12 mx-auto mb-4 text-blue-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg font-medium mb-2">Belum ada pengaduan</p>
                            <p class="text-sm text-blue-400/70">
                                @if(request()->has('status') || request()->has('category'))
                                    Tidak ada pengaduan dengan filter yang dipilih
                                @else
                                    Mulai dengan membuat pengaduan pertama Anda
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

/* Style untuk pagination */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    margin: 0 2px;
}

.pagination li a,
.pagination li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    border-radius: 6px;
    padding: 0 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.pagination li a {
    color: #93c5fd;
    background-color: rgba(30, 58, 138, 0.3);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.pagination li a:hover {
    background-color: rgba(59, 130, 246, 0.2);
    border-color: rgba(59, 130, 246, 0.4);
}

.pagination li span {
    color: #60a5fa;
    background-color: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.pagination .disabled span {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endpush