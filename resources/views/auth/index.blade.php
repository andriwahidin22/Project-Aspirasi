<x-guest-layout>
    @php
        $openRegister =
            $errors->has('ktm')
            || $errors->has('password_confirmation')
            || ($errors->has('email') && old('password_confirmation') !== null);

        $chartLabelsSafe = $chartLabels ?? ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $chartDataSafe   = $chartData ?? [0,0,0,0,0,0,0];

        $cPending  = data_get($statusCounts ?? [], 'pending', 0);
        $cDiproses = data_get($statusCounts ?? [], 'diproses', 0);
        $cSelesai  = data_get($statusCounts ?? [], 'selesai', 0);
        $cDitolak  = data_get($statusCounts ?? [], 'ditolak', 0);

        // Untuk grafik step-like, kita akan normalisasi data
        $maxValue = max($chartDataSafe) > 0 ? max($chartDataSafe) : 1;
        $goalLine = $maxValue * 0.8; // Garis target di 80% dari maksimum
    @endphp

    <div class="grid gap-6 md:grid-cols-4">
        <!-- Left -->
        <div class="md:col-span-1">
            <div class="rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-900/30 to-blue-800/20 p-5 shadow-lg">
                {{-- LOGO --}}
                <div class="mb-4 flex justify-center">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Logo"
                         class="h-12 w-auto object-contain"
                         onerror="this.style.display='none'">
                </div>

                <div class="flex items-center justify-between">
                    <button id="tabLogin" type="button"
                        class="{{ $openRegister
                            ? 'rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20'
                            : 'rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:from-blue-500 hover:to-blue-400 shadow-md' }}">
                        Login
                    </button>

                    <button id="tabRegister" type="button"
                        class="{{ $openRegister
                            ? 'rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:from-blue-500 hover:to-blue-400 shadow-md'
                            : 'rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20' }}">
                        Registrasi
                    </button>
                </div>

                {{-- Flash / Error --}}
                <div class="mt-4 space-y-2">
                    @if(session('success'))
                        <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-xs text-emerald-200">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-3 text-xs text-red-200">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="rounded-xl border border-amber-500/30 bg-amber-500/10 p-3 text-xs text-amber-200">
                            <div class="font-semibold mb-1">Periksa data Anda:</div>
                            <ul class="list-disc space-y-1 pl-4">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Login Form -->
                <form id="formLogin"
                      method="POST"
                      action="{{ route('login') }}"
                      class="mt-5 space-y-4 {{ $openRegister ? 'hidden' : '' }}">
                    @csrf

                    <div>
                        <label class="text-sm text-blue-100">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                               placeholder="email@example.com"
                               required>
                    </div>

                    <div>
                        <label class="text-sm text-blue-100">Password</label>
                        <input name="password" type="password"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                               placeholder="••••••••"
                               required>
                    </div>

                    <label class="flex items-center gap-2 text-xs text-blue-200">
                        <input name="remember" type="checkbox" class="rounded border-blue-400/50 bg-blue-900/30 text-blue-400 focus:ring-blue-400">
                        Ingat saya
                    </label>

                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3 3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </span>
                    </button>

                    <div class="text-xs text-blue-300/70 text-center">
                        Catatan: Akun mahasiswa akan dapat digunakan setelah Admin melakukan verifikasi.
                    </div>
                </form>

                <!-- Register Form -->
                <form id="formRegister"
                      method="POST"
                      action="{{ route('register') }}"
                      enctype="multipart/form-data"
                      class="mt-5 space-y-4 {{ $openRegister ? '' : 'hidden' }}">
                    @csrf

                    <div>
                        <label class="text-sm text-blue-100">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                               placeholder="email@example.com"
                               required>
                    </div>

                    <div>
                        <label class="text-sm text-blue-100">Password</label>
                        <input name="password" type="password"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                               placeholder="Minimal 8 karakter"
                               required>
                        <div class="mt-1 text-xs text-blue-300/60">Minimal 8 karakter</div>
                    </div>

                    <div>
                        <label class="text-sm text-blue-100">Konfirmasi Password</label>
                        <input name="password_confirmation" type="password"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white placeholder-blue-300/50 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"
                               placeholder="Ulangi password"
                               required>
                    </div>

                    <div>
                        <label class="text-sm text-blue-100">Upload KTM (Wajib)</label>
                        <input name="ktm" type="file" accept=".jpg,.jpeg,.png,.pdf"
                               class="mt-1 w-full rounded-xl border border-blue-400/30 bg-blue-900/30 px-3 py-2 text-white file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-500"
                               required>
                        <div class="mt-1 text-xs text-blue-300/60">Format: JPG/PNG/PDF. Maksimal: 10MB.</div>
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 font-semibold text-white shadow-md hover:from-blue-500 hover:to-blue-400 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar
                        </span>
                    </button>

                    <div class="text-xs text-blue-300/70 text-center">
                        Setelah mendaftar, akun Anda akan berstatus <span class="font-semibold text-amber-300">Menunggu Verifikasi</span> sampai Admin melakukan verifikasi.
                    </div>
                </form>
            </div>
        </div>

        <!-- Right -->
        <div class="md:col-span-3">
            <div class="rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-900/30 to-blue-800/20 p-6 shadow-lg">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-sm text-blue-200">Statistik Pengaduan Mingguan</div>
                        <div class="text-2xl font-bold text-white">Total: {{ $totalComplaints ?? 0 }}</div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="h-3 w-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-400"></div>
                            <span class="text-xs text-blue-300">Pengaduan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-3 w-3 rounded-full border-2 border-dashed border-emerald-400"></div>
                            <span class="text-xs text-blue-300">Target</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 h-72">
                    <canvas id="complaintChart" class="w-full"></canvas>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-4 transition-all duration-300 hover:border-blue-400/30 hover:bg-blue-900/30">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-blue-300">Pending</div>
                            <div class="h-2 w-2 rounded-full bg-amber-500"></div>
                        </div>
                        <div class="text-2xl font-bold text-white">{{ $cPending }}</div>
                        <div class="mt-1 text-xs text-blue-300/60">Menunggu tindakan</div>
                    </div>

                    <div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-4 transition-all duration-300 hover:border-blue-400/30 hover:bg-blue-900/30">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-blue-300">Diproses</div>
                            <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                        </div>
                        <div class="text-2xl font-bold text-white">{{ $cDiproses }}</div>
                        <div class="mt-1 text-xs text-blue-300/60">Sedang diproses</div>
                    </div>

                    <div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-4 transition-all duration-300 hover:border-blue-400/30 hover:bg-blue-900/30">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-blue-300">Selesai</div>
                            <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                        </div>
                        <div class="text-2xl font-bold text-white">{{ $cSelesai }}</div>
                        <div class="mt-1 text-xs text-blue-300/60">Telah diselesaikan</div>
                    </div>

                    <div class="rounded-2xl border border-blue-500/20 bg-blue-900/20 p-4 transition-all duration-300 hover:border-blue-400/30 hover:bg-blue-900/30">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-blue-300">Ditolak</div>
                            <div class="h-2 w-2 rounded-full bg-red-500"></div>
                        </div>
                        <div class="text-2xl font-bold text-white">{{ $cDitolak }}</div>
                        <div class="mt-1 text-xs text-blue-300/60">Pengaduan ditolak</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tabs
        const tabLogin = document.getElementById('tabLogin');
        const tabRegister = document.getElementById('tabRegister');
        const formLogin = document.getElementById('formLogin');
        const formRegister = document.getElementById('formRegister');

        function setTab(mode) {
            const isLogin = mode === 'login';
            formLogin.classList.toggle('hidden', !isLogin);
            formRegister.classList.toggle('hidden', isLogin);

            if (isLogin) {
                tabLogin.className = 'rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:from-blue-500 hover:to-blue-400 shadow-md';
                tabRegister.className = 'rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20';
            } else {
                tabRegister.className = 'rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-sm font-semibold text-white hover:from-blue-500 hover:to-blue-400 shadow-md';
                tabLogin.className = 'rounded-xl border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-200 hover:bg-blue-500/20';
            }
        }

        tabLogin.addEventListener('click', () => setTab('login'));
        tabRegister.addEventListener('click', () => setTab('register'));
        setTab(@json($openRegister ? 'register' : 'login'));

        // Chart data
        const labels = @json($chartLabelsSafe);
        const data = @json($chartDataSafe);
        const maxValue = Math.max(...data) > 0 ? Math.max(...data) : 1;
        const goalLine = maxValue * 0.8;

        const canvas = document.getElementById('complaintChart');
        const existing = Chart.getChart(canvas);
        if (existing) existing.destroy();

        // Background gradient for chart area
        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

        new Chart(canvas, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Jumlah Pengaduan',
                        data,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        borderWidth: 3
                    },
                    {
                        label: 'Target',
                        data: Array(data.length).fill(goalLine),
                        borderColor: 'rgba(16, 185, 129, 0.6)',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        tension: 0,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 58, 138, 0.95)',
                        titleColor: '#dbeafe',
                        bodyColor: '#e0f2fe',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            title: (items) => items?.[0]?.label ?? '',
                            label: (ctx) => {
                                if (ctx.datasetIndex === 0) {
                                    return ` ${ctx.raw} pengaduan`;
                                } else {
                                    return ` Target: ${Math.round(goalLine)}`;
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { 
                            color: 'rgba(59, 130, 246, 0.1)',
                            drawBorder: false
                        },
                        ticks: { 
                            color: '#93c5fd',
                            font: {
                                size: 13,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: 'rgba(59, 130, 246, 0.1)',
                            drawBorder: false
                        },
                        ticks: { 
                            color: '#93c5fd', 
                            precision: 0,
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        suggestedMax: Math.max(maxValue * 1.2, 10)
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                }
            }
        });

        // Add custom goal line label
        const goalLabel = document.createElement('div');
        goalLabel.className = 'absolute top-6 right-6 text-xs text-emerald-300';
        goalLabel.innerHTML = `
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full border-2 border-dashed border-emerald-400"></div>
                <span>Target: ${Math.round(goalLine)}</span>
            </div>
        `;
        
        // Find chart container and add label
        const chartContainer = canvas.parentElement;
        chartContainer.style.position = 'relative';
        chartContainer.appendChild(goalLabel);
    </script>
</x-guest-layout>