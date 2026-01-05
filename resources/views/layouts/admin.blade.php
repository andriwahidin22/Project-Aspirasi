<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - BEM Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .sidebar-active {
            background-color: #f43f5e;
            color: white;
        }
        
        .stat-card {
            background-color: #1f2937;
            border: 1px solid #374151;
            border-radius: 0.75rem;
            padding: 1rem;
            transition-property: border-color, background-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .stat-card:hover {
            border-color: #4b5563;
        }
        
        .table-header {
            background-color: #1f2937;
            color: #d1d5db;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        
        .table-row:hover {
            background-color: rgba(31, 41, 55, 0.5);
            transition-property: background-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .badge-pending {
            background-color: rgba(217, 119, 6, 0.2);
            color: #fcd34d;
            border: 1px solid rgba(217, 119, 6, 0.3);
        }
        
        .badge-processing {
            background-color: rgba(37, 99, 235, 0.2);
            color: #93c5fd;
            border: 1px solid rgba(37, 99, 235, 0.3);
        }
        
        .badge-completed {
            background-color: rgba(22, 163, 74, 0.2);
            color: #86efac;
            border: 1px solid rgba(22, 163, 74, 0.3);
        }
        
        .badge-rejected {
            background-color: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(220, 38, 38, 0.3);
        }
        
        .badge-admin {
            background-color: rgba(147, 51, 234, 0.2);
            color: #c4b5fd;
            border: 1px solid rgba(147, 51, 234, 0.3);
        }
        
        .badge-mahasiswa {
            background-color: rgba(8, 145, 178, 0.2);
            color: #a5f3fc;
            border: 1px solid rgba(8, 145, 178, 0.3);
        }
        
        .badge-verified {
            background-color: rgba(22, 163, 74, 0.2);
            color: #86efac;
            border: 1px solid rgba(22, 163, 74, 0.3);
        }
        
        .badge-unverified {
            background-color: rgba(217, 119, 6, 0.2);
            color: #fcd34d;
            border: 1px solid rgba(217, 119, 6, 0.3);
        }
    </style>
</head>
<body class="h-full text-gray-200">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-rose-600 to-pink-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg text-white">BEM Pengaduan</h1>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.complaints.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.complaints.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Data Pengaduan</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.02-.562.04-.843.06A10.003 10.003 0 0112 22c-5.523 0-10-4.477-10-10S6.477 2 12 2c4.357 0 8.067 2.786 9.426 6.672" />
                    </svg>
                    <span>Data User</span>
                </a>
                
                <a href="{{ route('admin.users.pending') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.users.pending') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Verifikasi User</span>
                    @php
                        $pendingCount = \App\Models\User::where('role', 'mahasiswa')
                            ->where('is_verified', false)
                            ->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-rose-600 text-xs px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </nav>
            
            <!-- User Info -->
            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-600 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="font-bold text-white text-sm">
                            {{ strtoupper(substr(auth()->user()->email, 0, 2)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-white">
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
            <header class="bg-gray-900 border-b border-gray-800 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-400">@yield('page-description', 'Admin Panel')</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ date('l, d F Y') }}
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-900">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-600/10 border border-green-600/20 text-green-300 p-4 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-600/10 border border-red-600/20 text-red-300 p-4 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 bg-red-600/10 border border-red-600/20 text-red-300 p-4 rounded-lg">
                        <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
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