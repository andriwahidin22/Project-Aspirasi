<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pengaduan #{{ $complaint->id }}</title>
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
        
        .complaint-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 15px;
        }
        
        .info-label {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .info-value {
            color: #333;
            font-size: 12px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 11px;
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
        
        .description-box {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .description-label {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
        }
        
        .evidence-box {
            margin-top: 20px;
        }
        
        .evidence-image {
            max-width: 100%;
            max-height: 200px;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .print-date {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .rejection-reason {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL PENGADUAN #{{ $complaint->id }}</h1>
        <p>BADAN EKSEKUTIF MAHASISWA UNIVERSITAS PENDIDIKAN INDONESIA</p>
    </div>
    
    <div class="print-date">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
    
    <div class="complaint-info">
        <div class="info-card">
            <div class="info-label">ID Pengaduan</div>
            <div class="info-value">#{{ $complaint->id }}</div>
        </div>
        
        <div class="info-card">
            <div class="info-label">Tanggal Dibuat</div>
            <div class="info-value">{{ $complaint->created_at->format('d/m/Y H:i') }}</div>
        </div>
        
        <div class="info-card">
            <div class="info-label">Pelapor</div>
            <div class="info-value">{{ $complaint->user->email ?? '-' }}</div>
        </div>
        
        <div class="info-card">
            <div class="info-label">Status</div>
            <div class="info-value">
                @php
                    $badgeClass = match($complaint->status) {
                        'pending' => 'badge-pending',
                        'diproses' => 'badge-processing',
                        'selesai' => 'badge-completed',
                        'ditolak' => 'badge-rejected',
                        default => '',
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ strtoupper($complaint->status) }}</span>
            </div>
        </div>
        
        <div class="info-card">
            <div class="info-label">Kategori</div>
            <div class="info-value">{{ ucfirst(str_replace('_', ' ', $complaint->category)) }}</div>
        </div>
        
        <div class="info-card">
            <div class="info-label">Terakhir Diupdate</div>
            <div class="info-value">{{ $complaint->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
    
    <div class="description-box">
        <div class="description-label">Judul Pengaduan</div>
        <div style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">{{ $complaint->title }}</div>
        
        <div class="description-label">Deskripsi / Kronologi</div>
        <div style="white-space: pre-line;">{{ $complaint->description }}</div>
    </div>
    
    @if($complaint->evidence_path)
    <div class="evidence-box">
        <div class="description-label">Bukti Pendukung</div>
        @php
            $fileExtension = pathinfo($complaint->evidence_path, PATHINFO_EXTENSION);
            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
        @endphp
        
        @if($isImage)
            <img src="{{ storage_path('app/public/' . $complaint->evidence_path) }}" 
                 class="evidence-image" 
                 alt="Bukti Pengaduan">
        @else
            <div style="background: #f1f5f9; padding: 10px; border-radius: 5px;">
                <strong>File:</strong> {{ basename($complaint->evidence_path) }}<br>
                <strong>Tipe:</strong> {{ strtoupper($fileExtension) }}
            </div>
        @endif
    </div>
    @endif
    
    @if($complaint->status === 'ditolak' && $complaint->rejection_reason)
    <div class="rejection-reason">
        <div style="font-weight: bold; color: #991b1b; margin-bottom: 5px;">ALASAN PENOLAKAN:</div>
        <div>{{ $complaint->rejection_reason }}</div>
    </div>
    @endif
    
    <div class="footer">
        <p>Dokumen ini bersifat rahasia dan hanya untuk keperluan administrasi BEM UPI</p>
        <p>©️ {{ date('Y') }} BEM Universitas Pendidikan Indonesia</p>
    </div>
</body>
</html>