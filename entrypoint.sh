#!/bin/sh
set -e

# استارت مفسر PHP-FPM در پس‌زمینه
/usr/sbin/php-fpm83 -F &

# استارت وب‌سرور Nginx در پیش‌زمینه (نگه داشتن کانتینر)
exec /usr/sbin/nginx -g "daemon off;"