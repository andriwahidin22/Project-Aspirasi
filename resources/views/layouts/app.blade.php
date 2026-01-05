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
    <div class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="font-bold">Pengaduan BEM</div>
                </div>

                <div class="flex items-center gap-3 text-sm text-zinc-300">
                    <div class="hidden md:block">
                        {{ auth()->check() ? auth()->user()->email : '' }}
                    </div>

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 hover:bg-white/10">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-6">
        @include('partials.flash')
        {{ $slot }}
    </div>
</body>
</html>
