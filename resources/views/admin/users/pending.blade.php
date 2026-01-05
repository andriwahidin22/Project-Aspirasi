@extends('layouts.admin')

@section('title', 'Verifikasi User')
@section('page-title', 'Verifikasi User')
@section('page-description', 'Verifikasi akun mahasiswa baru')

@section('content')
    <!-- Stats -->
    <div class="stat-card mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-medium text-gray-400">Akun Menunggu Verifikasi</h3>
                <p class="text-2xl font-bold text-white mt-1">{{ $pendingUsers->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-600/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- User Table -->
    @if($pendingUsers->count() > 0)
    <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">Daftar Mahasiswa Pending</h3>
            <p class="text-sm text-gray-400">Verifikasi dengan melihat KTM mereka</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">KTM</th>
                        <th class="py-3 px-6 text-left">Tanggal Daftar</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-700">
                    @foreach ($pendingUsers as $user)
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-400">Menunggu verifikasi</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="py-4 px-6">
                            @if($user->ktm_path)
                            <a href="{{ route('view.ktm', basename($user->ktm_path)) }}" 
                               target="_blank" 
                               class="inline-flex items-center space-x-2 px-3 py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 text-xs rounded-lg border border-blue-600/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Lihat KTM</span>
                            </a>
                            @else
                            <span class="text-gray-500 text-sm">Tidak ada KTM</span>
                            @endif
                        </td>
                        
                        <td class="py-4 px-6 text-gray-300">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </td>
                        
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Verifikasi akun {{ $user->email }}?')"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg">
                                        Approve
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      onsubmit="return confirm('Tolak dan hapus akun {{ $user->email }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <div class="w-16 h-16 bg-green-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-white mb-2">Semua akun telah terverifikasi</h3>
        <p class="text-gray-400">Tidak ada akun mahasiswa yang menunggu verifikasi.</p>
    </div>
    @endif
@endsection