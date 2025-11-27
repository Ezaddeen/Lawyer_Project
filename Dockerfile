# المرحلة الأولى: تثبيت الاعتماديات
FROM composer:latest as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader

# المرحلة الثانية: بناء الصورة النهائية مع Apache
FROM php:8.2-apache
WORKDIR /app

# تثبيت الإضافات اللازمة
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip intl gd

# نسخ ملفات التطبيق
COPY . .

# نسخ الاعتماديات من المرحلة الأولى
COPY --from=vendor /app/vendor/ ./vendor/

# إعداد Apache
COPY <<EOF /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /app/public

    <Directory /app/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

RUN a2enmod rewrite

# تعديل الصلاحيات
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# هذا السطر مهم لـ Railway ليعرف أي منفذ يستخدم
EXPOSE 80
