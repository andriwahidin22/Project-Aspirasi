<?php
//app/Http/Controllers/MahasiswaController.php
namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function dashboard(): View
    {
        $userId = Auth::id();

        $counts = [
            'total'   => Complaint::where('user_id', $userId)->count(),
            'pending' => Complaint::where('user_id', $userId)->where('status', 'pending')->count(),
            'diproses'=> Complaint::where('user_id', $userId)->where('status', 'diproses')->count(),
            'selesai' => Complaint::where('user_id', $userId)->where('status', 'selesai')->count(),
            'ditolak' => Complaint::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        $rejectedComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'ditolak')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get(['id', 'title', 'rejection_reason', 'updated_at']);

        return view('mahasiswa.dashboard', compact('counts', 'rejectedComplaints'));
    }
}