# PHP 8.2 image kullanıyoruz
FROM php:8.2-fpm

# Sistem bağımlılıklarını yükleyelim (Laravel ve Composer için gerekli)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Composer'ı yükleyelim
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel projesinin bulunduğu dizine geçiş
WORKDIR /var/www

# Proje dosyalarını konteynerimize kopyalayalım
COPY . .

# Bağımlılıkları yükleyelim
RUN composer install --no-dev --optimize-autoloader

# PHP-FPM çalıştırma komutunu ekleyelim
CMD ["php-fpm"]

# Varsayılan port 9000'dir
EXPOSE 9000
