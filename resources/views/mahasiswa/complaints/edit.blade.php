@extends('layouts.mahasiswa')

@section('title', 'Edit Pengaduan')
@section('page-title', 'Edit Pengaduan')
@section('page-description', 'Perbarui pengaduan Anda')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Flash + Error ringkas -->
        @if(session('success') || session('error') || $errors->any())
        <div class="mb-6 space-y-3">
            @if(session('success'))
                <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-xl border border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-200">
                    <div class="flex items-start gap-2">
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div class="flex-1">
                            <div class="font-semibold mb-1">Periksa input berikut:</div>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-amber-100/90">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif

        <div class="rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-900/30 to-blue-800/20 p-6 shadow-lg">
            <form method="POST"
                  action="{{ route('mahasiswa.complaints.update', $complaint) }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- INFO STATUS -->
                <div class="rounded-xl bg-blue-800/30 border border-blue-400/20 p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-blue-200">
                            Anda hanya dapat mengedit pengaduan dengan status <strong class="text-yellow-300">Pending</strong>.
                        </span>
                    </div>
                </div>

                <!-- KATEGORI KASUS -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Kategori Kasus</label>
                    <select name="category"
                            class="mt-2 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-4 py-3 text-white outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                            required>
                        <option value="" disabled>-- Pilih Kategori Pengaduan --</option>
                        <option value="bullying" @selected($complaint->category === 'bullying')>Bullying</option>
                        <option value="lgbt" @selected($complaint->category === 'lgbt')>LGBT</option>
                        <option value="kekerasan_seksual" @selected($complaint->category === 'kekerasan_seksual')>Kekerasan Seksual</option>
                        <option value="cat_calling" @selected($complaint->category === 'cat_calling')>Cat Calling</option>
                        <option value="akademik" @selected($complaint->category === 'akademik')>Akademik</option>
                        <option value="fasilitas" @selected($complaint->category === 'fasilitas')>Fasilitas</option>
                        <option value="lainnya" @selected($complaint->category === 'lainnya')>Lainnya</option>
                    </select>
                    <div class="mt-2 text-xs text-blue-300/70">Pilih kategori yang paling sesuai dengan laporan Anda</div>
                </div>

                <!-- JUDUL -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Judul Pengaduan</label>
                    <input name="title"
                           value="{{ old('title', $complaint->title) }}"
                           maxlength="120"
                           placeholder="Masukkan judul singkat dan jelas"
                           class="mt-2 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-4 py-3 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                           required>
                    <div class="mt-2 text-xs text-blue-300/70">Maksimal 120 karakter</div>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Deskripsi / Kronologi Lengkap</label>
                    <textarea name="description"
                              rows="7"
                              placeholder="Jelaskan kronologi kejadian secara detail (waktu, tempat, pihak terkait, dll)"
                              class="mt-2 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-4 py-3 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                              required>{{ old('description', $complaint->description) }}</textarea>
                    <div class="mt-2 text-xs text-blue-300/70">Detailkan informasi untuk membantu proses penyelesaian</div>
                </div>

                <!-- BUKTI -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Upload Bukti Pendukung (Opsional)</label>
                    
                    @if($complaint->evidence_path)
                    <div class="mt-2 mb-3 p-3 rounded-lg bg-blue-800/30 border border-blue-400/20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-sm text-blue-200">Bukti sudah diupload</span>
                            </div>
                            <a href="{{ route('view.bukti', basename($complaint->evidence_path)) }}"
                               target="_blank"
                               class="text-sm text-blue-400 hover:text-blue-300 hover:underline">
                                Lihat Bukti
                            </a>
                        </div>
                        <p class="text-xs text-blue-400/60 mt-2">
                            Upload file baru akan menggantikan bukti yang lama.
                        </p>
                    </div>
                    @endif

                    <div>
                        <input name="evidence"
                               type="file"
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="w-full rounded-xl border border-blue-400/30 bg-blue-900/30 p-4 text-white file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-500">
                    </div>
                    <div class="mt-2 text-xs text-blue-300/70">
                        Format: JPG, PNG, PDF. Maksimal: 10MB (direkomendasikan untuk memperkuat laporan)
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Simpan Perubahan
                        </span>
                    </button>

                    <a href="{{ route('mahasiswa.complaints.index') }}"
                       class="rounded-xl border border-blue-400/30 bg-blue-500/10 px-5 py-3 text-sm font-semibold text-blue-200 hover:bg-blue-500/20 transition-all duration-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

