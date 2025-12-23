# 🐳 Render'da Docker ile Deployment

Render'da PHP Language seçeneği yoksa Docker kullanabilirsiniz. Dockerfile hazır!

## 📋 Render'da Yapmanız Gerekenler

### 1️⃣ Web Service Oluştur
1. Render Dashboard → "New +" → "Web Service"
2. Repository: `Farukaksungur/kargo`
3. Branch: `main`

### 2️⃣ Otomatik Algılama
- Render Dockerfile'ı otomatik algılayacak
- "Docker" modu otomatik seçilecek
- Build Command ve Start Command otomatik ayarlanacak

### 3️⃣ Environment Variables Ekle

Render dashboard'da "Environment" sekmesine gidin:

```
APP_NAME=Kargo Yönetim
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

**ÖNEMLİ:** Dockerfile içinde database path `/var/www/database/database.sqlite` olarak ayarlandı.

### 4️⃣ APP_KEY (Opsiyonel)
- İlk deployment'ta otomatik oluşturulacak
- Veya manuel ekleyebilirsiniz:
  ```bash
  php artisan key:generate
  ```
  Çıktıyı `APP_KEY` olarak ekleyin.

### 5️⃣ Deploy!
- "Create Web Service" butonuna tıklayın
- Docker build başlayacak (5-10 dakika sürebilir)
- Build loglarını takip edin

## ✅ Dockerfile Özellikleri

- ✅ PHP 8.4 CLI kullanıyor
- ✅ SQLite desteği var
- ✅ Composer otomatik kuruluyor
- ✅ Dependencies otomatik yükleniyor
- ✅ SQLite database otomatik oluşturuluyor
- ✅ Migrations otomatik çalışıyor
- ✅ Cache'ler otomatik oluşturuluyor
- ✅ Storage link otomatik oluşturuluyor
- ✅ Render'ın PORT variable'ını kullanıyor

## 🔧 Manuel Build/Start Komutları (Gerekirse)

Eğer Render otomatik algılamazsa:

**Build Command:**
```bash
docker build -t kargo-yonetim .
```

**Start Command:**
```bash
docker run -p $PORT:$PORT -e PORT=$PORT kargo-yonetim
```

Ama genellikle Render otomatik algılar, bu komutlara gerek yok.

## 🎯 Özet

- ✅ Dockerfile hazır ve Render için optimize edildi
- ✅ SQLite desteği var
- ✅ Tüm işlemler otomatik
- ✅ Sadece Environment Variables ekleyin
- ✅ Deploy edin!

