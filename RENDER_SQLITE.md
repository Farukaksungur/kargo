# 🚀 Render'da SQLite ile Deployment (Basit Yöntem)

SQLite kullanarak Render'da deployment yapmak çok daha basit! PostgreSQL kurulumuna gerek yok.

## ✅ Avantajları
- ✅ Database kurulumu gerekmez
- ✅ Daha hızlı setup
- ✅ Free plan için ideal
- ✅ Basit projeler için yeterli

## ⚠️ Sınırlamaları
- ⚠️ Render'da SQLite dosyası geçici olabilir (yeniden deploy'da sıfırlanabilir)
- ⚠️ Çok yüksek trafik için uygun değil
- ⚠️ Eşzamanlı yazma işlemleri sınırlı

## 📋 Render Deployment Adımları (SQLite ile)

### 1️⃣ Render Dashboard'a Giriş
- https://render.com → GitHub ile giriş yapın

### 2️⃣ Yeni Web Service Oluştur
1. "New +" → "Web Service"
2. Repository: `Farukaksungur/kargo`
3. Branch: `main`

### 3️⃣ Build & Start Ayarları

**Build Command:**
```bash
chmod +x .render-build.sh && ./.render-build.sh
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

### 4️⃣ Environment Variables (Sadece Bunlar Yeterli!)

Render dashboard'da "Environment" sekmesine gidin:

```
APP_NAME=Kargo Yönetim
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
LOG_CHANNEL=stderr
LOG_LEVEL=error

# SQLite için (varsayılan zaten SQLite)
DB_CONNECTION=sqlite
DB_DATABASE=/opt/render/project/src/database/database.sqlite

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

**ÖNEMLİ:** `DB_DATABASE` yolunu Render'ın proje dizinine göre ayarlayın. Build script otomatik oluşturacak ama path'i doğru belirtmek önemli.

### 5️⃣ Deploy!
- "Create Web Service" butonuna tıklayın
- İlk deployment 5-10 dakika sürebilir
- Build loglarını takip edin

## 🔧 Build Script'teki Değişiklikler

Build script şunları yapacak:
1. SQLite database dosyasını oluşturacak
2. Gerekli izinleri ayarlayacak
3. Migrations'ı çalıştıracak

## 💡 Veri Kalıcılığı İçin

Eğer verilerinizin kalıcı olmasını istiyorsanız:

1. **Render Disk Storage kullanın** (ücretli plan gerekebilir)
2. **Veya PostgreSQL'e geçin** (önerilen, free plan'da mevcut)
3. **Veya düzenli backup alın**

## 🎯 Özet

SQLite ile deployment çok daha basit:
- ✅ Database kurulumu yok
- ✅ Sadece environment variables ekleyin
- ✅ Deploy edin
- ✅ Hazır!

PostgreSQL'e geçmek isterseniz daha sonra kolayca geçiş yapabilirsiniz.

