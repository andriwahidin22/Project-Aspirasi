# 🌐 BEM Pengaduan - Akses Publik (Internet)

Panduan untuk membuat aplikasi bisa diakses teman Anda dari **mana saja** via internet.

## 🚀 Cara Menjalankan

### Jalankan di Terminal:

```bash
cd /Users/andriwahidin/Downloads/bem-pengaduan
npm run public
```

### Atau manual (3 terminal):

**Terminal 1 - Laravel Server:**
```bash
cd /Users/andriwahidin/Downloads/bem-pengaduan
php artisan serve --host=0.0.0.0 --port=8000
```

**Terminal 2 - Vite Dev Server:**
```bash
cd /Users/andriwahidin/Downloads/bem-pengaduan
npm run dev
```

**Terminal 3 - LocalTunnel (Tunnel Publik):**
```bash
cd /Users/andriwahidin/Downloads/bem-pengaduan
lt --port 8000
```

## 🔗 Cara Teman Anda Mengakses

1. Jalankan `npm run public`
2. Tunggu sampai muncul link seperti ini:

   ```
   your url is: https://great-monkeys-jump-41-222-187-226.loca.lt
   ```

3. **Berikan link tersebut ke teman Anda!**
   - Teman tidak perlu WiFi sama
   - Teman bisa akses dari HP/Data mereka
   - Link bisa diakses dari **mana saja** di internet

## 📡 Port yang Digunakan

| Service | Port |
|---------|------|
| Laravel | 8000 |
| Vite HMR | 5173 |

## ⏱️ Catatan Penting

1. **Link Sementara:** Link dari localtunnel akan berubah setiap kali Anda restart
2. **Komputer Menyala:** Komputer Anda harus ONLINE agar teman bisa akses
3. **Gratis:** localtunnel gratis tapi dengan batasan tertentu

## 🔄 Jika Ingin Link Stabil

Untuk link permanen, pertimbangkan:
- **ngrok** - tunnel berbayar tapi stabil
- **Cloudflare Tunnel** - gratis dan stabil
- **Deploy ke hosting** - solusi paling stabil

## 🛠️ Troubleshooting

### Jika tunnel error:
```bash
# Install ulang localtunnel
npm install -D localtunnel
```

### Jika port sudah terpakai:
```bash
# Ubah port di vite.config.js
# Ubah port saat running
lt --port 8080
```

---

**Happy Testing! 🎉**

