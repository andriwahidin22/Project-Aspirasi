<?php
//
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        // =========================
        // Total per STATUS (ALL TIME)
        // =========================
        $statusCounts = Complaint::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pending  = (int)($statusCounts['pending'] ?? 0);
        $diproses = (int)($statusCounts['diproses'] ?? 0);
        $selesai  = (int)($statusCounts['selesai'] ?? 0);
        $ditolak  = (int)($statusCounts['ditolak'] ?? 0);

        $totalAll = $pending + $diproses + $selesai + $ditolak;

        // =========================
        // Grafik: TREND KASUS berdasarkan CATEGORY (30 hari terakhir)
        // =========================
        $days = 30;
        $from = now()->subDays($days - 1)->startOfDay();

        // Ambil jumlah per category (30 hari terakhir)
        // COALESCE agar data lama yang null masuk "lainnya"
        $categoryRaw = Complaint::query()
            ->where('created_at', '>=', $from)
            ->selectRaw("COALESCE(category, 'lainnya') as category, COUNT(*) as total")
            ->groupBy('category')
            ->orderByDesc('total')
            ->pluck('total', 'category')
            ->toArray();

        // Map label supaya rapi di chart & card
        $categoryLabelMap = [
            'bullying'          => 'Bullying',
            'lgbt'              => 'LGBT',
            'kekerasan'         => 'Kekerasan',
            'kekerasan_seksual' => 'Kekerasan Seksual',
            'cat_calling'       => 'Cat Calling',
            'akademik'          => 'Akademik',
            'fasilitas'         => 'Fasilitas',
            'lainnya'           => 'Lainnya',
        ];

        // =========================
        // Chart (BAR): top 6 kategori (biar gak kepanjangan)
        // =========================
        $maxBars = 6;
        $chartLabels = [];
        $chartData   = [];

        $trendTopLabel = '-';
        $trendTopCount = 0;

        if (!empty($categoryRaw)) {
            $i = 0;
            foreach ($categoryRaw as $key => $count) {
                $label = $categoryLabelMap[$key] ?? ucwords(str_replace('_', ' ', (string)$key));

                if ($i === 0) {
                    $trendTopLabel = $label;
                    $trendTopCount = (int)$count;
                }

                if ($i < $maxBars) {
                    $chartLabels[] = $label;
                    $chartData[]   = (int)$count;
                }

                $i++;
            }
        } else {
            $chartLabels = ['Bullying', 'LGBT', 'Kekerasan Seksual', 'Cat Calling', 'Akademik', 'Lainnya'];
            $chartData   = [0, 0, 0, 0, 0, 0];
        }

        // =========================
        // Cards bawah grafik: JUDUL KASUS SAJA (TOP 4 kategori terbanyak)
        // =========================
        $topCategoryCards = [];
        $topN = 4;

        if (!empty($categoryRaw)) {
            $i = 0;
            foreach ($categoryRaw as $key => $count) {
                $label = $categoryLabelMap[$key] ?? ucwords(str_replace('_', ' ', (string)$key));
                $topCategoryCards[] = $label; // ✅ judul saja
                $i++;
                if ($i >= $topN) break;
            }
        }

        // fallback biar selalu ada 4 judul
        if (count($topCategoryCards) < 4) {
            $fallback = ['Bullying', 'LGBT', 'Kekerasan Seksual', 'Cat Calling'];
            foreach ($fallback as $f) {
                if (count($topCategoryCards) >= 4) break;
                if (!in_array($f, $topCategoryCards, true)) $topCategoryCards[] = $f;
            }
        }

        return view('auth.index', [
            // grafik kategori trending
            'chartLabels'    => $chartLabels,
            'chartData'      => $chartData,
            'trendDays'      => $days,
            'trendTopLabel'  => $trendTopLabel,
            'trendTopCount'  => $trendTopCount,

            // total publik
            'totalComplaints' => $totalAll,

            // ✅ cards judul kasus saja
            'topCategoryCards' => $topCategoryCards,

            // kalau masih kamu butuh statusCounts di tempat lain, biarkan ada:
            'statusCounts' => [
                'pending'  => $pending,
                'diproses' => $diproses,
                'selesai'  => $selesai,
                'ditolak'  => $ditolak,
                'total'    => $totalAll,
            ],
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'ktm' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf'],
        ], [
            'ktm.required' => 'File KTM wajib diunggah.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'ktm.file' => 'File KTM wajib diunggah.',
            'ktm.max' => 'Ukuran file KTM maksimal 10MB.',
            'ktm.mimes' => 'Format file KTM harus JPG, PNG, atau PDF.',
        ]);

        $ktmPath = $request->file('ktm')->store('ktm', 'public');

        User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
            'is_verified' => false,
            'ktm_path' => $ktmPath,
            'remember_token' => Str::random(10),
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Akun Anda menunggu verifikasi dari Admin. Silakan tunggu konfirmasi.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->with('error', 'Email atau password yang Anda masukkan salah.')->withInput();
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        if ($user->role === 'mahasiswa' && !$user->is_verified) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'Akun Anda belum diverifikasi oleh Admin. Mohon tunggu konfirmasi.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
    public function dashboard(): View
    {
        $counts = [
            'pending_accounts' => User::where('role', 'mahasiswa')
                ->where('is_verified', false)
                ->count(),
            'total_complaints' => Complaint::count(),
            'complaints_pending' => Complaint::where('status', 'pending')->count(),
            'complaints_diproses' => Complaint::where('status', 'diproses')->count(),
            'complaints_selesai' => Complaint::where('status', 'selesai')->count(),
            'complaints_ditolak' => Complaint::where('status', 'ditolak')->count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
