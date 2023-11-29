FROM php:7.3-apache

RUN apt-get update

# ====================================
# Сначала устанавливаем базовые пакеты
# ====================================

RUN apt-get install -fyqq \
    curl \
    wget \
    cron \
    nano

# ====================================
# Затем, используя скрипт он вендора PHP устанавливаем расширения PHP
# ====================================

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions gd opcache zip

# ====================================
# Меняем корневую директорию Apache заменой файла Virtual Host
# ====================================
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ====================================
# Composer ( использовать через cli контейнера)
# ====================================
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install xdebug
RUN pecl install xdebug-3.0.0 \
 && docker-php-ext-enable xdebug

# ====================================
# Запускаем стартовые скрипты
# ====================================

COPY start.sh /root/start.sh
# На случай если start.sh был создан в Windows
RUN sed -i -e 's/\r$//' /root/start.sh
CMD ["/root/start.sh"]

