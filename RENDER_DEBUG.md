# 🔍 Render'da 500 Hatası Giderme

## 1️⃣ Hemen Yapılacaklar (Render Dashboard)

### Environment Variables'ı Güncelleyin

Render dashboard'da "Environment" sekmesine gidin ve şunları ekleyin/güncelleyin:

```
APP_DEBUG=true
LOG_LEVEL=debug
LOG_CHANNEL=stderr
```

Bu sayede hataları görebilirsiniz.

## 2️⃣ Yaygın Sorunlar ve Çözümleri

### ❌ APP_KEY Eksik
**Hata:** `No application encryption key has been specified`

**Çözüm:**
Render dashboard'da Environment Variables'a ekleyin:
```
APP_KEY=
```
Boş bırakın, build script otomatik oluşturacak.

Veya manuel oluşturun:
```bash
php artisan key:generate
```
Çıktıyı `APP_KEY` olarak ekleyin.

### ❌ Database Bağlantı Hatası
**Hata:** `SQLSTATE[HY000] [14] unable to open database file`

**Çözüm:**
SQLite için doğru path:
```
DB_DATABASE=/var/www/database/database.sqlite
```

Veya Dockerfile'da path kontrol edin.

### ❌ Storage Permissions
**Hata:** `The stream or file could not be opened`

**Çözüm:**
Dockerfile'a storage permissions ekleyin:
```dockerfile
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
```

### ❌ Cache Hatası
**Hata:** Cache ile ilgili hatalar

**Çözüm:**
Environment Variables'a ekleyin:
```
CACHE_DRIVER=file
SESSION_DRIVER=file
```

## 3️⃣ Render Logs Kontrolü

1. Render Dashboard'da service'inize gidin
2. "Logs" sekmesine tıklayın
3. Son logları kontrol edin
4. Hata mesajlarını arayın

## 4️⃣ Dockerfile Güncellemesi

Dockerfile'ı güncelleyerek daha iyi hata yakalama ekleyebiliriz.

