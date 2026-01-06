@extends('layouts.mahasiswa')

@section('title', 'Buat Pengaduan')
@section('page-title', 'Buat Pengaduan Baru')
@section('page-description', 'Form pengaduan untuk BEM UPI')

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
                  action="{{ route('mahasiswa.complaints.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- KATEGORI KASUS -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Kategori Kasus</label>
                    <select name="category"
                            class="mt-2 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-4 py-3 text-white outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                            required>
                        <option value="" disabled @selected(old('category')===null)>-- Pilih Kategori Pengaduan --</option>
                        <option value="bullying"          @selected(old('category')==='bullying')>Bullying</option>
                        <option value="lgbt"              @selected(old('category')==='lgbt')>LGBT</option>
                        <option value="kekerasan_seksual" @selected(old('category')==='kekerasan_seksual')>Kekerasan Seksual</option>
                        <option value="cat_calling"       @selected(old('category')==='cat_calling')>Cat Calling</option>
                        <option value="akademik"          @selected(old('category')==='akademik')>Akademik</option>
                        <option value="fasilitas"         @selected(old('category')==='fasilitas')>Fasilitas</option>
                        <option value="lainnya"           @selected(old('category')==='lainnya')>Lainnya</option>
                    </select>
                    <div class="mt-2 text-xs text-blue-300/70">Pilih kategori yang paling sesuai dengan laporan Anda</div>
                </div>

                <!-- JUDUL -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Judul Pengaduan</label>
                    <input name="title"
                           value="{{ old('title') }}"
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
                              id="description"
                              rows="7"
                              placeholder="Jelaskan kronologi kejadian secara detail (waktu, tempat, pihak terkait, dll)"
                              class="mt-2 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-4 py-3 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                              oninput="updateWordCount(this)"
                              required>{{ old('description') }}</textarea>
                    <div class="mt-2 flex justify-between text-xs">
                        <span class="text-blue-300/70">Detailkan informasi untuk membantu proses penyelesaian</span>
                        <span id="wordCount" class="text-blue-300/70">0/300 kata</span>
                    </div>
                </div>

                <!-- BUKTI -->
                <div>
                    <label class="text-sm font-medium text-blue-100 mb-2">Upload Bukti Pendukung (Opsional)</label>
                    <div class="mt-2">
                        <input name="evidence"
                               type="file"
                               accept=".jpg,.jpeg,.png,.pdf,.mp4,.webm,.mp3,.wav,.ogg,.doc,.docx"
                               class="w-full rounded-xl border border-blue-400/30 bg-blue-900/30 p-4 text-white file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-500">
                    </div>
                    <div class="mt-2 text-xs text-blue-300/70">
                        Format: JPG, PNG, PDF, MP4, WEBM, MP3, WAV, OGG, DOC, DOCX. Maksimal: 50MB
                    </div>
                </div>

                @push('scripts')
                <script>
                function countWords(str) {
                    str = str.trim();
                    if (str === '') return 0;
                    return str.split(/\s+/).filter(word => word.length > 0).length;
                }

                function updateWordCount(textarea) {
                    const words = countWords(textarea.value);
                    const counter = document.getElementById('wordCount');
                    counter.textContent = words + '/300 kata';
                    
                    if (words > 300) {
                        counter.classList.add('text-red-400');
                        counter.classList.remove('text-blue-300/70');
                    } else {
                        counter.classList.remove('text-red-400');
                        counter.classList.add('text-blue-300/70');
                    }
                }

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    const desc = document.getElementById('description');
                    if (desc) updateWordCount(desc);
                });
                </script>
                @endpush

                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Kirim Pengaduan
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