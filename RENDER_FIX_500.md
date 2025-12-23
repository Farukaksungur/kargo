# 🚨 Render'da 500 Hatası - Hızlı Çözüm

## ⚡ Hemen Yapılacaklar

### 1. Render Dashboard'da Environment Variables Güncelle

**"Environment" sekmesine git ve şunları ekle/güncelle:**

```
APP_DEBUG=true
LOG_LEVEL=debug
LOG_CHANNEL=stderr
```

Bu sayede hataları görebilirsin!

### 2. APP_KEY Kontrolü

**Environment Variables'a ekle:**
```
APP_KEY=
```
Boş bırak, build script otomatik oluşturacak.

### 3. Database Path Kontrolü

**SQLite için:**
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite
```

### 4. Render Logs Kontrol Et

1. Render Dashboard → Service'inize gidin
2. **"Logs"** sekmesine tıklayın
3. Son logları kontrol edin
4. Kırmızı hata mesajlarını arayın

## 🔧 Yaygın Hatalar ve Çözümleri

### Hata 1: "No application encryption key"
**Çözüm:** APP_KEY ekle veya boş bırak (otomatik oluşur)

### Hata 2: "Unable to open database file"
**Çözüm:** DB_DATABASE path'ini kontrol et: `/var/www/database/database.sqlite`

### Hata 3: "Permission denied" (storage)
**Çözüm:** Dockerfile güncellendi, yeniden deploy et

### Hata 4: "Class not found"
**Çözüm:** Composer dependencies eksik, build loglarını kontrol et

## 📋 Kontrol Listesi

- [ ] APP_DEBUG=true yapıldı
- [ ] LOG_LEVEL=debug yapıldı
- [ ] APP_KEY eklendi (veya boş bırakıldı)
- [ ] DB_DATABASE path doğru
- [ ] Render Logs kontrol edildi
- [ ] Service yeniden deploy edildi

## 🔄 Yeniden Deploy

Değişikliklerden sonra:
1. Render Dashboard'da service'inize gidin
2. "Manual Deploy" → "Deploy latest commit"
3. Build loglarını takip edin
4. Deploy tamamlandıktan sonra tekrar test edin

## 💡 Logları Görmek İçin

Render Dashboard'da:
- **Logs** sekmesi → Canlı loglar
- **Events** sekmesi → Deployment olayları
- **Metrics** sekmesi → Performans metrikleri

