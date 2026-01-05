@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan sistem pengaduan')

@php
    $cPending = $counts['complaints_pending'] ?? 0;
    $cDiproses = $counts['complaints_diproses'] ?? 0;
    $cSelesai = $counts['complaints_selesai'] ?? 0;
    $cDitolak = $counts['complaints_ditolak'] ?? 0;
    $totalAll = $counts['total_complaints'] ?? 0;
    
    // Data untuk chart
    $chartData = [
        'labels' => ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
        'data' => [$cPending, $cDiproses, $cSelesai, $cDitolak],
        'colors' => ['#f59e0b', '#3b82f6', '#10b981', '#ef4444']
    ];
@endphp

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-400">Total Pengaduan</h3>
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-white">{{ $totalAll }}</p>
            <p class="text-xs text-gray-400 mt-1">Total semua pengaduan</p>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-400">Pending</h3>
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-white">{{ $cPending }}</p>
            <p class="text-xs text-gray-400 mt-1">Menunggu tindakan</p>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-400">Diproses</h3>
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-white">{{ $cDiproses }}</p>
            <p class="text-xs text-gray-400 mt-1">Sedang diproses</p>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-400">Selesai</h3>
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-white">{{ $cSelesai }}</p>
            <p class="text-xs text-gray-400 mt-1">Telah diselesaikan</p>
        </div>
    </div>
    
    <!-- Chart dan Status Sistem -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Section -->
        <div class="lg:col-span-2">
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">Statistik Pengaduan</h3>
                    <p class="text-sm text-gray-400">Distribusi status pengaduan</p>
                </div>
                
                <div class="p-6">
                    <!-- Chart Container -->
                    <div class="relative h-64">
                        <canvas id="complaintsChart"></canvas>
                    </div>
                    
                    <!-- Chart Legend -->
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-sm text-gray-300">Pending</span>
                            <span class="text-sm font-semibold text-white ml-auto">{{ $cPending }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-300">Diproses</span>
                            <span class="text-sm font-semibold text-white ml-auto">{{ $cDiproses }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-300">Selesai</span>
                            <span class="text-sm font-semibold text-white ml-auto">{{ $cSelesai }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-300">Ditolak</span>
                            <span class="text-sm font-semibold text-white ml-auto">{{ $cDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- System Status & Quick Actions -->
        <div class="space-y-6">
            <!-- System Status -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">Status Sistem</h3>
                    <p class="text-sm text-gray-400">Informasi terbaru</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-300">Sistem aktif</span>
                        </div>
                        <span class="text-xs text-gray-400">Normal</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full {{ $counts['pending_accounts'] > 0 ? 'bg-yellow-500' : 'bg-green-500' }}"></div>
                            <span class="text-sm text-gray-300">User pending</span>
                        </div>
                        <span class="text-xs {{ $counts['pending_accounts'] > 0 ? 'text-yellow-400' : 'text-green-400' }}">
                            {{ $counts['pending_accounts'] ?? 0 }} akun
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full {{ $cPending > 0 ? 'bg-rose-500' : 'bg-green-500' }}"></div>
                            <span class="text-sm text-gray-300">Pengaduan baru</span>
                        </div>
                        <span class="text-xs {{ $cPending > 0 ? 'text-rose-400' : 'text-green-400' }}">
                            {{ $cPending }} laporan
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full {{ $cDiproses > 0 ? 'bg-blue-500' : 'bg-gray-500' }}"></div>
                            <span class="text-sm text-gray-300">Sedang diproses</span>
                        </div>
                        <span class="text-xs {{ $cDiproses > 0 ? 'text-blue-400' : 'text-gray-400' }}">
                            {{ $cDiproses }} laporan
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full {{ $cSelesai > 0 ? 'bg-green-500' : 'bg-gray-500' }}"></div>
                            <span class="text-sm text-gray-300">Terselesaikan</span>
                        </div>
                        <span class="text-xs {{ $cSelesai > 0 ? 'text-green-400' : 'text-gray-400' }}">
                            {{ $cSelesai }} laporan
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">Aksi Cepat</h3>
                    <p class="text-sm text-gray-400">Akses cepat ke menu</p>
                </div>
                
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.complaints.index') }}" 
                       class="flex items-center justify-between p-3 rounded-lg border border-gray-700 hover:border-blue-500 hover:bg-gray-800/50 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-rose-600/20 rounded-lg flex items-center justify-center group-hover:bg-rose-600/30">
                                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-300">Data Pengaduan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    
                    <a href="{{ route('admin.users.pending') }}" 
                       class="flex items-center justify-between p-3 rounded-lg border border-gray-700 hover:border-yellow-500 hover:bg-gray-800/50 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-600/20 rounded-lg flex items-center justify-center group-hover:bg-yellow-600/30">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-300">Verifikasi User</span>
                        </div>
                        @if(($counts['pending_accounts'] ?? 0) > 0)
                            <span class="px-2 py-1 text-xs bg-yellow-600 text-white rounded-full">
                                {{ $counts['pending_accounts'] }}
                            </span>
                        @else
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center justify-between p-3 rounded-lg border border-gray-700 hover:border-blue-500 hover:bg-gray-800/50 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center group-hover:bg-blue-600/30">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.02-.562.04-.843.06A10.003 10.003 0 0112 22c-5.523 0-10-4.477-10-10S6.477 2 12 2c4.357 0 8.067 2.786 9.426 6.672" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-300">Data User</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('complaintsChart').getContext('2d');
    
    // Data untuk chart
    const chartData = {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
            data: {!! json_encode($chartData['data']) !!},
            backgroundColor: {!! json_encode($chartData['colors']) !!},
            borderColor: {!! json_encode(array_map(function($color) {
                return $color;
            }, $chartData['colors'])) !!},
            borderWidth: 1,
            hoverOffset: 10
        }]
    };
    
    // Konfigurasi chart
    const config = {
        type: 'doughnut',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw;
                            return label;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    };
    
    // Buat chart
    new Chart(ctx, config);
});
</script>
@endpush

@push('styles')
<style>
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
        transform: translateY(-0.25rem);
    }
</style>
@endpush
