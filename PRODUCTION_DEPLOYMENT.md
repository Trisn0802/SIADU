# Instruksi Update untuk Production Server

Setelah push kode ke production, jalankan perintah berikut di VPS:

```bash
# 1. Pull latest code
cd /var/www/siadu
git pull origin main

# 2. Install composer dependencies
composer install --no-dev

# 3. Update .env (copy dari LOCAL .env yang sudah updated)
# Pastikan:
# BROADCAST_DRIVER=websockets
# LARAVEL_WEBSOCKETS_PORT=6001

# 4. Clear cache
php artisan config:cache
php artisan cache:clear

# 5. Run migrations (jika ada migration baru)
php artisan migrate --force

# 6. Setup WebSocket Service dengan Systemd (PENTING!)
# Copy file dari dokumentasi WEBSOCKET_SETUP.md

sudo tee /etc/systemd/system/siadu-websocket.service > /dev/null <<EOF
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
EOF

# 7. Enable dan start WebSocket service
sudo systemctl daemon-reload
sudo systemctl enable siadu-websocket
sudo systemctl start siadu-websocket

# 8. Verify service running
sudo systemctl status siadu-websocket

# 9. Check logs
tail -f /var/log/syslog | grep websocket
```

---

## IMPORTANT: Update Nginx Configuration

Tambahkan location block untuk WebSocket proxy di Nginx VirtualHost:

```nginx
# Di dalam server {} block untuk siadu.trisnahome.my.id

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

Setelah update config:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

---

## Verifikasi di Production

1. **Check WebSocket Server Running:**
   ```bash
   ps aux | grep "websockets:serve"
   ```

2. **Test Connection:**
   - Akses https://siadu.trisnahome.my.id
   - Buka browser console (F12)
   - Tidak boleh ada error "WebSocket failed" atau "CORS"

3. **Monitor WebSocket:**
   ```bash
   sudo systemctl status siadu-websocket
   tail -f /var/log/siadu-websocket.log  # jika pakai Supervisor
   journalctl -u siadu-websocket -f      # jika pakai Systemd
   ```

---

**Done! Real-time chat seharusnya sudah bekerja di production.** ✅
