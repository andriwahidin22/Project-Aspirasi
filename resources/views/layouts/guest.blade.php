<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    boxShadow: { soft: '0 10px 25px rgba(0,0,0,.35)' },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-black via-zinc-950 to-rose-950 text-zinc-100">
    <div class="mx-auto max-w-7xl px-4 py-6 md:py-10">

        @php
            // default: header disembunyikan (biar bagian yang kamu kotakin HILANG)
            $showHeader = $showHeader ?? false;
        @endphp

        {{-- HEADER (opsional) --}}
        @if($showHeader)
            <div class="mb-6">
                <div>
                    <div class="text-sm text-zinc-300">Sistem Informasi</div>
                    <div class="text-xl font-bold text-white">Pengaduan BEM</div>
                </div>
            </div>
        @endif

        @include('partials.flash')

        {{ $slot }}

        <div class="mt-10 text-center text-xs text-zinc-500">
            Grafik publik hanya menampilkan kategori (tanpa NPM/Nama pelapor) untuk menjaga privasi.
        </div>
    </div>
</body>
</html>
