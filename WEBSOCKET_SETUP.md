# Laravel WebSocket Setup Guide

## Instalasi Selesai ✅

Package `beyondcode/laravel-websockets` sudah berhasil diinstall di project Anda.

---

## Konfigurasi Environment

### Local Development
File `.env` sudah dikonfigurasi:
```env
BROADCAST_DRIVER=websockets
LARAVEL_WEBSOCKETS_HOST=0.0.0.0
LARAVEL_WEBSOCKETS_PORT=6001
LARAVEL_WEBSOCKETS_INTERNAL_HOST=127.0.0.1
LARAVEL_WEBSOCKETS_INTERNAL_PORT=6001
```

### Production (VPS)
Untuk production dengan domain HTTPS (https://siadu.trisnahome.my.id):

**Update .env di VPS:**
```env
BROADCAST_DRIVER=websockets
LARAVEL_WEBSOCKETS_HOST=0.0.0.0
LARAVEL_WEBSOCKETS_PORT=6001
LARAVEL_WEBSOCKETS_INTERNAL_HOST=127.0.0.1
LARAVEL_WEBSOCKETS_INTERNAL_PORT=6001
```

---

## Cara Menjalankan WebSocket Server

### Local Development (Windows)
Buka 2 terminal:

**Terminal 1 - Laravel Development Server:**
```bash
php artisan serve
# Akses di: http://localhost:8000
```

**Terminal 2 - WebSocket Server:**
```bash
php artisan websockets:serve
# Server running di: ws://localhost:6001
```

### Production (Linux VPS)
Jalankan WebSocket server sebagai background service menggunakan **Supervisor** atau **Systemd**.

#### Option A: Menggunakan Supervisor
1. Install Supervisor:
```bash
sudo apt-get install supervisor
```

2. Buat config file `/etc/supervisor/conf.d/siadu-websocket.conf`:
```ini
[program:siadu-websocket]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/siadu/artisan websockets:serve
autostart=true
autorestart=true
numprocs=1
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/siadu-websocket.log
```

3. Reload Supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start siadu-websocket:*
```

#### Option B: Menggunakan Systemd (Recommended)
1. Buat file `/etc/systemd/system/siadu-websocket.service`:
```ini
[Unit]
Description=SIADU WebSocket Server
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/siadu
ExecStart=/usr/bin/php /var/www/siadu/artisan websockets:serve
Restart=on-failure
RestartSec=10

[Install]
WantedBy=multi-user.target
```

2. Enable dan start service:
```bash
sudo systemctl daemon-reload
sudo systemctl enable siadu-websocket
sudo systemctl start siadu-websocket
```

3. Check status:
```bash
sudo systemctl status siadu-websocket
```

---

## Nginx Proxy Configuration (untuk Production HTTPS)

Jika menggunakan Nginx, tambahkan konfigurasi proxy untuk WebSocket:

```nginx
location /app {
    proxy_pass http://localhost:6001;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_read_timeout 86400;
}
```

---

## Testing WebSocket Connection

### Local
1. Buka http://localhost:8000
2. Buka browser console (F12)
3. Cek apakah tidak ada error WebSocket

### Production
1. Buka https://siadu.trisnahome.my.id
2. Buka browser console (F12)
3. Tidak boleh ada error "CORS policy" atau "ERR_FAILED"

---

## Fitur WebSocket yang Sudah Aktif

✅ Real-time Chat di detail aduan  
✅ Live Notifikasi  
✅ Broadcast event update status  

---

## Dashboard WebSocket

Akses dashboard WebSocket untuk monitoring:

**Local:** http://localhost:6001/laravel-websockets  
**Production:** https://siadu.trisnahome.my.id/laravel-websockets

Credentials: Tidak ada (dapat dikustomisasi di `config/websockets.php`)

---

## Troubleshooting

### Error: "WebSocket connection failed"
- Pastikan port 6001 tidak diblokir firewall
- Cek config Nginx proxy forward WebSocket headers dengan benar

### WebSocket server tidak running
```bash
php artisan websockets:serve
```
Jalankan manual untuk debugging.

### Connection terbuat tapi tidak ada data
- Pastikan `BROADCAST_DRIVER=websockets` di `.env`
- Restart WebSocket server
- Check Laravel logs: `storage/logs/laravel.log`

---

## Update Database Migration

Jika belum run migration untuk WebSocket statistics:
```bash
php artisan migrate
```

---

## Dokumentasi Resmi
https://beyondcode.io/docs/laravel-websockets/

