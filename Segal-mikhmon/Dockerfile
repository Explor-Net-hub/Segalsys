FROM php:8.3-apache
RUN docker-php-ext-install sockets && a2enmod headers
WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html/
RUN mkdir -p /var/www/html/img /var/www/html/voucher \
    && chown -R www-data:www-data /var/www/html/include /var/www/html/img /var/www/html/voucher \
    && chmod -R u=rwX,g=rX,o=rX /var/www/html
COPY docker/apache-security.conf /etc/apache2/conf-enabled/security-mikhmon.conf
EXPOSE 80
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 CMD php -r '$h=@get_headers("http://127.0.0.1/admin.php?id=login"); exit($h && str_contains($h[0], "200") ? 0 : 1);'
