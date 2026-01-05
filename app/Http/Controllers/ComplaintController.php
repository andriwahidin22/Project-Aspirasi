<?php
// app/Http/Controllers/ComplaintController.php
namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf; // TAMBAHKAN INI

class ComplaintController extends Controller
{
    // =========================
    // MAHASISWA
    // =========================
    public function indexMahasiswa(Request $request): View
    {
        $query = Complaint::query()
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $complaints = $query->paginate(10);

        return view('mahasiswa.complaints.index', compact('complaints'));
    }

    public function create(): View
    {
        return view('mahasiswa.complaints.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'category' => ['required', 'in:bullying,lgbt,kekerasan_seksual,cat_calling,akademik,fasilitas,lainnya'],
            'evidence' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('bukti', 'public');
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'evidence_path' => $evidencePath,
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('mahasiswa.complaints.index')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function show(Complaint $complaint): View
    {
        // Pastikan hanya pemilik yang bisa melihat
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('mahasiswa.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint): View
    {
        // Pastikan hanya pemilik dan status pending yang bisa edit
        if ($complaint->user_id !== Auth::id() || $complaint->status !== 'pending') {
            abort(403);
        }
        
        return view('mahasiswa.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        // Pastikan hanya pemilik dan status pending yang bisa update
        if ($complaint->user_id !== Auth::id() || $complaint->status !== 'pending') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'category' => ['required', 'in:bullying,lgbt,kekerasan_seksual,cat_calling,akademik,fasilitas,lainnya'],
            'evidence' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $evidencePath = $complaint->evidence_path;
        if ($request->hasFile('evidence')) {
            // Hapus file lama jika ada
            if ($evidencePath && Storage::disk('public')->exists($evidencePath)) {
                Storage::disk('public')->delete($evidencePath);
            }
            $evidencePath = $request->file('evidence')->store('bukti', 'public');
        }

        $complaint->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'evidence_path' => $evidencePath,
        ]);

        return redirect()
            ->route('mahasiswa.complaints.index')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // TAMBAHKAN METHOD DESTROY INI
    public function destroy(Complaint $complaint): RedirectResponse
    {
        // Pastikan hanya pemilik dan status pending yang bisa hapus
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus pengaduan ini.');
        }

        if ($complaint->status !== 'pending') {
            return back()->with('error', 'Hanya pengaduan dengan status "Pending" yang bisa dihapus.');
        }

        // Hapus file bukti jika ada
        if ($complaint->evidence_path && Storage::disk('public')->exists($complaint->evidence_path)) {
            Storage::disk('public')->delete($complaint->evidence_path);
        }

        $complaint->delete();

        return redirect()
            ->route('mahasiswa.complaints.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    // =========================
    // ADMIN
    // =========================
    public function indexAdmin(Request $request): View
    {
        $query = Complaint::query()
            ->with('user')
            ->orderByDesc('created_at');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $complaints = $query->paginate(15);

        // Hitung status untuk statistik
        $statusCounts = Complaint::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Total semua pengaduan
        $statusCounts['total'] = array_sum($statusCounts);

        return view('admin.complaints.index', compact('complaints', 'statusCounts'));
    }

    public function showAdmin(Complaint $complaint): View
    {
        $complaint->load('user');
        return view('admin.complaints.show', compact('complaint'));
    }

    // Ubah status (pending/diproses/selesai)
    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,diproses,selesai'],
        ]);

        // Update status
        $complaint->update([
            'status' => $validated['status'],
            'rejection_reason' => null, // Kosongkan alasan ditolak jika status bukan ditolak
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui menjadi ' . $validated['status']);
    }

    // Tolak pengaduan + alasan
    public function reject(Request $request, Complaint $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:255'],
        ]);

        // Update status ke ditolak dan tambahkan alasan
        $complaint->update([
            'status' => 'ditolak',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Pengaduan berhasil ditolak.');
    }

    // Export PDF
    public function exportPDF(Request $request)
    {
        $query = Complaint::query()->with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $complaints = $query->orderBy('created_at', 'desc')->get();
        
        // Load PDF view
        $pdf = Pdf::loadView('admin.complaints.export.pdf', [
            'complaints' => $complaints,
            'status' => $request->status,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ]);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'laporan-pengaduan-' . date('Y-m-d') . '.pdf';
        
        if ($request->status) {
            $filename = 'laporan-pengaduan-' . $request->status . '-' . date('Y-m-d') . '.pdf';
        }
        
        // Download PDF
        return $pdf->download($filename);
    }

    // Export detail single complaint
    public function exportSinglePDF(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.complaints.export.single', [
            'complaint' => $complaint->load('user'),
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'pengaduan-' . $complaint->id . '-' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}