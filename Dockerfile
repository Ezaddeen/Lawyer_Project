# ---------------------------------------------------------------------
# المرحلة الأولى: بناء بيئة الاعتماديات (Builder)
# ---------------------------------------------------------------------
# نستخدم نفس صورة PHP التي سنستخدمها في النهاية لضمان التوافق
FROM php:8.2-apache AS builder

WORKDIR /app

# تثبيت الأدوات والملحقات اللازمة لـ Composer
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) zip intl gd

# نسخ Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع اللازمة لتثبيت الاعتماديات فقط
COPY database/ database/
COPY composer.json composer.lock ./

# تثبيت الاعتماديات (مع تجاهل متطلبات المنصة كإجراء احترازي)
RUN composer install --no-scripts --optimize-autoloader --ignore-platform-reqs


# ---------------------------------------------------------------------
# المرحلة الثانية: بناء الصورة النهائية للتشغيل (Final Image)
# ---------------------------------------------------------------------
FROM php:8.2-apache

WORKDIR /app

# تثبيت الملحقات اللازمة لتشغيل التطبيق
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip intl gd

# نسخ كل ملفات المشروع
COPY . .

# نسخ مجلد vendor الجاهز من مرحلة البناء
COPY --from=builder /app/vendor/ ./vendor/

# إعداد خادم Apache
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
