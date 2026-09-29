#!/bin/sh
set -e

# استارت مفسر PHP-FPM در پس‌زمینه
/usr/sbin/php-fpm83 -F &

# استارت Nginx در پس‌زمینه و ذخیره PID آن
/usr/sbin/nginx -g "daemon off;" &
NGINX_PID=$!

# زنده نگه داشتن کانتینر و انتظار برای اتمام پردازش وب‌سرور
wait "$NGINX_PID"