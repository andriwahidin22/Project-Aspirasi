@extends('layouts.admin')

@section('title', 'Data User')
@section('page-title', 'Data User')
@section('page-description', 'Kelola semua pengguna sistem')

@section('content')
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stat-card">
            <h3 class="text-sm font-medium text-gray-400 mb-2">Total User</h3>
            <p class="text-2xl font-bold text-white">{{ $users->total() }}</p>
        </div>
        
        <div class="stat-card">
            <h3 class="text-sm font-medium text-gray-400 mb-2">Admin</h3>
            <p class="text-2xl font-bold text-white">{{ $users->where('role', 'admin')->count() }}</p>
        </div>
        
        <div class="stat-card">
            <h3 class="text-sm font-medium text-gray-400 mb-2">Mahasiswa</h3>
            <p class="text-2xl font-bold text-white">{{ $users->where('role', 'mahasiswa')->count() }}</p>
        </div>
    </div>
    
    <!-- User Table -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Daftar User</h3>
                    <p class="text-sm text-gray-400">Semua pengguna terdaftar</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Tanggal Daftar</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-700">
                    @forelse ($users as $user)
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">
                                        {{ strtoupper(substr($user->email, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $user->email }}</p>
                                    @if($user->name)
                                        <p class="text-xs text-gray-400">{{ $user->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium 
                                {{ $user->role === 'admin' ? 'badge-admin' : 'badge-mahasiswa' }}">
                                {{ $user->role === 'admin' ? 'ADMIN' : 'MAHASISWA' }}
                            </span>
                        </td>
                        
                        <td class="py-4 px-6">
                            @if($user->role === 'mahasiswa')
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium 
                                    {{ $user->is_verified ? 'badge-verified' : 'badge-unverified' }}">
                                    {{ $user->is_verified ? 'TERVERIFIKASI' : 'BELUM VERIFIKASI' }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        
                        <td class="py-4 px-6 text-gray-300">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </td>
                        
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                @if($user->role === 'mahasiswa' && !$user->is_verified)
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Verifikasi akun {{ $user->email }}?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                          onsubmit="return confirm('Hapus user {{ $user->email }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-gray-400">
                            Tidak ada data user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="p-6 border-t border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection