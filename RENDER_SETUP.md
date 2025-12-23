# Render Deployment Rehberi

Bu doküman, Laravel Kargo Yönetim projesini Render platformunda çalıştırmak için gerekli adımları içerir.

## 📋 Render'da Proje Oluşturma

### 1. Render Dashboard'a Giriş
1. https://render.com adresine gidin
2. GitHub hesabınızla giriş yapın
3. "New +" butonuna tıklayın
4. "Web Service" seçeneğini seçin

### 2. Repository Bağlama
1. GitHub repository'nizi seçin: `Farukaksungur/kargo`
2. Branch: `main`
3. Root Directory: (boş bırakın)

### 3. Build & Start Ayarları

**Build Command:**
```bash
chmod +x render-build.sh && ./render-build.sh
```

veya manuel olarak:
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

### 4. Environment Variables (Ortam Değişkenleri)

Render dashboard'da "Environment" sekmesine gidin ve şu değişkenleri ekleyin:

#### Zorunlu Değişkenler:
```
APP_NAME=Kargo Yönetim
APP_ENV=production
APP_KEY=base64:... (php artisan key:generate ile oluşturulacak)
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

LOG_CHANNEL=stderr
LOG_LEVEL=error
```

#### Database Ayarları (Render PostgreSQL için):
```
DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=kargo
DB_USERNAME=kargo_user
DB_PASSWORD=your-db-password
```

#### Session & Cache:
```
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

#### Mail Ayarları (Opsiyonel):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Basit Kargo API (Opsiyonel):
```
BASITKARGO_API_TOKEN=your-api-token
BASITKARGO_BASE_URL=https://basitkargo.com/api
```

### 5. Database Oluşturma

1. Render Dashboard'da "New +" → "PostgreSQL"
2. Database adı: `kargo-db`
3. Plan: Free (veya istediğiniz plan)
4. Database oluşturulduktan sonra "Internal Database URL" değerini kopyalayın
5. Bu URL'yi parse ederek environment variables'a ekleyin:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`

### 6. Storage Link

Render'da storage link oluşturmak için build script'e ekleyin:
```bash
php artisan storage:link
```

### 7. Deployment

1. Tüm ayarları yaptıktan sonra "Create Web Service" butonuna tıklayın
2. İlk deployment otomatik başlayacak
3. Build loglarını takip edin
4. Deployment tamamlandığında URL'niz hazır olacak

## 🔧 Önemli Notlar

### Database Migration
- İlk deployment'da migrations otomatik çalışacak
- Sonraki deployment'larda migration çalıştırmak istemezseniz build script'ten kaldırın

### File Storage
- Render'da dosya storage geçici olabilir
- Kalıcı dosya storage için AWS S3 veya benzeri bir servis kullanmanız önerilir

### Queue Jobs
- Queue job'lar için ayrı bir "Background Worker" oluşturmanız gerekebilir
- Start Command: `php artisan queue:work`

### Cron Jobs
- Scheduled task'lar için "Cron Job" servisi oluşturun
- Command: `php artisan schedule:run`

## 🐛 Sorun Giderme

### Build Hatası
- Build loglarını kontrol edin
- Composer dependencies eksik olabilir
- PHP versiyonu uyumsuz olabilir (Render PHP 8.2+ destekler)

### Database Bağlantı Hatası
- Environment variables'ı kontrol edin
- Database'in hazır olduğundan emin olun
- Internal Database URL'yi doğru parse ettiğinizden emin olun

### 500 Error
- `APP_DEBUG=true` yaparak hata mesajlarını görebilirsiniz
- Logs sekmesinden logları kontrol edin
- Storage permissions kontrol edin

## 📚 Ek Kaynaklar

- [Render Laravel Documentation](https://render.com/docs/deploy-laravel)
- [Render Environment Variables](https://render.com/docs/environment-variables)
- [Render PostgreSQL](https://render.com/docs/databases)

## ✅ Deployment Checklist

- [ ] GitHub repository bağlandı
- [ ] Build command ayarlandı
- [ ] Start command ayarlandı
- [ ] Environment variables eklendi
- [ ] Database oluşturuldu ve bağlandı
- [ ] APP_KEY oluşturuldu
- [ ] APP_URL ayarlandı
- [ ] Storage link oluşturuldu (gerekirse)
- [ ] İlk deployment başarılı
- [ ] Site çalışıyor

