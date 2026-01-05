<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mahasiswa') - BEM Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .sidebar-active {
            @apply bg-gradient-to-r from-blue-600 to-blue-500 text-white;
        }
        
        .sidebar-inactive {
            @apply text-blue-200 hover:bg-blue-500/10 hover:text-white;
        }
        
        .stat-card {
            @apply bg-gradient-to-br from-blue-900/30 to-blue-800/20 border border-blue-500/20 rounded-xl p-4 hover:border-blue-400/30 transition-all duration-300;
        }
        
        .table-header {
            @apply bg-blue-900/30 text-blue-300 uppercase text-xs font-semibold tracking-wider;
        }
        
        .badge-pending { @apply bg-amber-500/20 text-amber-300 border border-amber-500/30; }
        .badge-processing { @apply bg-blue-500/20 text-blue-300 border border-blue-500/30; }
        .badge-completed { @apply bg-emerald-500/20 text-emerald-300 border border-emerald-500/30; }
        .badge-rejected { @apply bg-red-500/20 text-red-300 border border-red-500/30; }
    </style>
</head>
<body class="h-full text-gray-200">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-blue-900/80 to-blue-800/60 border-r border-blue-500/20 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-blue-500/20">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg text-white">BEM Pengaduan</h1>
                        <p class="text-xs text-blue-300">Mahasiswa Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('mahasiswa.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('mahasiswa.dashboard') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('mahasiswa.complaints.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('mahasiswa.complaints.*') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Riwayat Pengaduan</span>
                </a>
                
                <a href="{{ route('mahasiswa.complaints.create') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('mahasiswa.complaints.create') ? 'sidebar-active' : 'sidebar-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Pengaduan Baru</span>
                </a>
            </nav>
            
            <!-- User Info -->
            <div class="p-4 border-t border-blue-500/20">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center">
                        <span class="font-bold text-white text-sm">
                            {{ strtoupper(substr(auth()->user()->email, 0, 2)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-blue-300">Mahasiswa</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-blue-300 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-gradient-to-r from-blue-900/60 to-blue-800/40 border-b border-blue-500/20 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-blue-300">@yield('page-description', 'Mahasiswa Panel')</p>
                    </div>
                    <div class="text-sm text-blue-300">
                        {{ date('l, d F Y') }}
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-br from-gray-900 via-black to-gray-900">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 rounded-xl border border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-200">
                        <div class="font-semibold mb-2">Periksa input berikut:</div>
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>