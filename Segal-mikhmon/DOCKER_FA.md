# اجرای سامانه با Docker

از پوشه اصلی پروژه:

```bash
docker compose up -d --build
```

نشانی: `http://localhost:8080/admin.php?id=login` (با `APP_PORT` می‌توان درگاه را تغییر داد).

ساخت ایمیج برای Docker Hub پس از تعیین نام کاربری خود:

```bash
docker build -t YOUR_DOCKERHUB_USERNAME/segal-mikhmon:latest .
docker login
docker push YOUR_DOCKERHUB_USERNAME/segal-mikhmon:latest
```

برای دسترسی به روتر، کانتینر باید به IP و پورت API روتر MikroTik دسترسی شبکه داشته باشد. این بسته روتر شبیه‌سازی‌شده همراه ندارد. تنظیمات در فایل‌های درون کانتینر نوشته می‌شوند؛ پیش از تعویض کانتینر از تنظیمات و قالب‌های سفارشی نسخه پشتیبان تهیه کنید. سامانه را بدون HTTPS و محدودیت دسترسی روی اینترنت عمومی منتشر نکنید. نام کاربری و رمز اولیه: `segal` / `segal`. پس از اولین ورود، رمز مدیر را تغییر دهید.
