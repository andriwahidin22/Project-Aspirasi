#!/bin/bash

# Script untuk menjalankan aplikasi BEM Pengaduan dengan akses publik
# Ikuti langkah-langkah di bawah ini

echo "=============================================="
echo "  BEM Pengaduan - Akses Publik"
echo "=============================================="
echo ""

# Dapatkan IP lokal komputer
IP_LOCAL=$(ipconfig getifaddr en0 2>/dev/null || ipconfig getifaddr en1 2>/dev/null || echo "IP_NOT_FOUND")

if [ "$IP_LOCAL" = "IP_NOT_FOUND" ]; then
    echo "⚠️  Tidak dapat menemukan IP otomatis"
    echo "   Silakan cari IP Anda dengan: ifconfig"
else
    echo "✅ IP Lokal Anda: http://$IP_LOCAL:8000"
fi

echo ""
echo "📋 Cara Menggunakan:"
echo "   1. Buka terminal baru (Terminal 2)"
echo "   2. Jalankan: npm run dev"
echo "   3. Berikan IP ini ke teman Anda:"
echo "      http://$IP_LOCAL:8000"
echo ""
echo "=============================================="
echo ""

# Install dependencies jika belum ada
if [ ! -d "node_modules" ]; then
    echo "📦 Menginstall dependencies..."
    npm install
fi

echo "🚀 Menjalankan Laravel dan Vite server..."
echo ""
echo "🟢 PORT LARAVEL: 8000"
echo "🟢 PORT VITE:     5173"
echo ""
echo "Teman Anda bisa akses dari: http://$IP_LOCAL:8000"
echo ""

# Jalankan npm run dev dan php artisan serve bersamaan
concurrently "npm run dev" "php artisan serve --host=0.0.0.0 --port=8000"

