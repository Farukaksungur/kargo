# PHP 8.4 image kullan
FROM php:8.4-fpm

# Sistem bağımlılıklarını yükleyelim
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libzip-dev

# Composer'ı yükleyelim
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel için gerekli PHP uzantılarını yükleyelim
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Çalışma dizinini ayarla
WORKDIR /var/www

# Proje dosyalarını konteynerimize kopyalayalım
COPY . .

# Bağımlılıkları yükleyelim
RUN composer install --no-dev --optimize-autoloader

# PHP-FPM ile servis çalıştır
CMD ["php-fpm"]

# Varsayılan port 80'i aç
EXPOSE 80
