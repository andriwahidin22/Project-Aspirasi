<?php
//app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    // Dashboard utama dengan statistik
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

    // Approve user verification
    public function approve(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'mahasiswa') {
            return back()->with('error', 'Hanya akun mahasiswa yang bisa diverifikasi.');
        }

        $user->is_verified = true;
        $user->save();

        return back()->with('success', 'Mahasiswa berhasil diverifikasi.');
    }

    // Data semua user
    public function usersIndex(): View
    {
        $users = User::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // Verifikasi user pending
    public function usersPending(): View
    {
        $pendingUsers = User::where('role', 'mahasiswa')
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.pending', compact('pendingUsers'));
    }

    // Delete user
    public function userDestroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->user()?->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
