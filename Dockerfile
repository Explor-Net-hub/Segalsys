FROM alpine:3.20

RUN apk add --no-cache \
    nginx \
    php83 \
    php83-fpm \
    php83-session \
    php83-json \
    php83-curl \
    php83-openssl \
    php83-sockets \
    php83-mbstring \
    supervisor \
    tzdata

ENV TZ=Asia/Tehran

WORKDIR /var/www/html

COPY . /var/www/html/

# تنظیم پورت گوش‌به‌زنگ PHP-FPM روی 127.0.0.1:9000
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /etc/php83/php-fpm.d/www.conf && \
    sed -i 's|^user = .*|user = nobody|' /etc/php83/php-fpm.d/www.conf && \
    sed -i 's|^group = .*|group = nobody|' /etc/php83/php-fpm.d/www.conf

# تنظیم Nginx همراه با مسدودسازی دسترسی به دات‌فایل‌ها و کش استاتیک‌ها
RUN mkdir -p /run/nginx /run/php && \
    echo 'server { \
        listen 80 default_server; \
        listen [::]:80 default_server; \
        root /var/www/html; \
        index index.php index.html; \
        server_name _; \
        \
        location / { \
            try_files $uri $uri/ /index.php?$args; \
        } \
        \
        location ~ \.php$ { \
            fastcgi_pass 127.0.0.1:9000; \
            fastcgi_index index.php; \
            include fastcgi_params; \
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        } \
        \
        location ~ /\. { \
            deny all; \
            access_log off; \
            log_not_found off; \
        } \
        \
        location ~* \.(bak|old|orig|original|sql|yml|yaml|md|txt)$ { \
            deny all; \
            access_log off; \
            log_not_found off; \
        } \
        \
        location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ { \
            expires 30d; \
            add_header Cache-Control "public, no-transform"; \
            access_log off; \
        } \
    }' > /etc/nginx/http.d/default.conf

# تنظیم پرمیشن دایرکتوری‌ها
RUN chown -R nobody:nobody /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 /var/www/html/include /var/www/html/voucher

# پیکربندی Supervisord
RUN echo -e '[supervisord]\nnodaemon=true\nuser=root\n\n[program:php-fpm]\ncommand=/usr/sbin/php-fpm83 -F\nautostart=true\nautorestart=true\n\n[program:nginx]\ncommand=/usr/sbin/nginx -g "daemon off;"\nautostart=true\nautorestart=true' > /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]