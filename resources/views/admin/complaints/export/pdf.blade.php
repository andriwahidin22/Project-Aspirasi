<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan - BEM KBM POLINELA</title>
    <style>
        @page {
            margin: 20mm;
            size: A4 portrait;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #1e3a8a;
            font-size: 24px;
            margin: 0;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
        }
        
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .info-value {
            color: #333;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .table th {
            background-color: #1e3a8a;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            border: 1px solid #ddd;
        }
        
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
            vertical-align: top;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        
        .badge-processing {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #60a5fa;
        }
        
        .badge-completed {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }
        
        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .evidence-image {
            max-width: 150px;
            max-height: 150px;
            margin: 5px 0;
        }
        
        .description {
            max-width: 300px;
            word-wrap: break-word;
        }
        
        .rejection-reason {
            background-color: #fef2f2;
            border-left: 3px solid #ef4444;
            padding: 8px;
            margin-top: 5px;
            font-size: 10px;
        }
        
        .print-date {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        
        .stat-card {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .stat-label {
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PENGADUAN</h1>
        <p>BADAN EKSEKUTIF MAHASISWA Politeknik Negeri Lampung</p>
        <p>Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua Waktu' }} 
           - {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}</p>
    </div>
    
    <div class="print-date">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
    
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Filter Status:</div>
            <div class="info-value">{{ $status ? ucfirst($status) : 'Semua Status' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Total Data:</div>
            <div class="info-value">{{ $complaints->count() }} pengaduan</div>
        </div>
        <div class="info-row">
            <div class="info-label">Admin:</div>
            <div class="info-value">{{ auth()->user()->email }}</div>
        </div>
    </div>
    
    <div class="stats-summary">
        <div class="stat-card">
            <div class="stat-number">{{ $complaints->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $complaints->where('status', 'diproses')->count() }}</div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $complaints->where('status', 'selesai')->count() }}</div>
            <div class="stat-label">Selesai</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $complaints->where('status', 'ditolak')->count() }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $complaints->count() }}</div>
            <div class="stat-label">Total</div>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Judul</th>
                <th width="15%">Pelapor</th>
                <th width="10%">Status</th>
                <th width="25%">Deskripsi</th>
                <th width="10%">Bukti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $index => $complaint)
            @php
                $badgeClass = match($complaint->status) {
                    'pending' => 'badge-pending',
                    'diproses' => 'badge-processing',
                    'selesai' => 'badge-completed',
                    'ditolak' => 'badge-rejected',
                    default => '',
                };
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $complaint->title }}</strong></td>
                <td>{{ $complaint->user->email ?? '-' }}</td>
                <td><span class="badge {{ $badgeClass }}">{{ strtoupper($complaint->status) }}</span></td>
                <td class="description">{{ Str::limit($complaint->description, 150) }}</td>
                <td>
                    @if($complaint->evidence_path)
                        @php
                            $fileExtension = pathinfo($complaint->evidence_path, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp
                        
                        @if($isImage)
                            <img src="{{ storage_path('app/public/' . $complaint->evidence_path) }}" 
                                 class="evidence-image" 
                                 alt="Bukti">
                        @else
                            <div style="font-size: 9px; color: #666;">
                                File: {{ basename($complaint->evidence_path) }}
                            </div>
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            
            @if($complaint->status === 'ditolak' && $complaint->rejection_reason)
            <tr>
                <td colspan="7" style="padding: 0;">
                    <div class="rejection-reason">
                        <strong>Alasan Ditolak:</strong> {{ $complaint->rejection_reason }}
                    </div>
                </td>
            </tr>
            @endif
            
            @if(($index + 1) % 15 == 0 && !$loop->last)
            </tbody>
            </table>
            
            <div class="page-break"></div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Judul</th>
                        <th width="15%">Pelapor</th>
                        <th width="10%">Status</th>
                        <th width="25%">Deskripsi</th>
                        <th width="10%">Bukti</th>
                    </tr>
                </thead>
                <tbody>
            @endif
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Pengaduan BEM UPI</p>
        <p>©️ {{ date('Y') }} BEM Universitas Pendidikan Indonesia</p>
    </div>
</body>
</html>