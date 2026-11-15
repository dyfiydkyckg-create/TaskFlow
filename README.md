# ✦ TaskFlow

### مدیریت کارها، با تمرکز بیشتر و آشفتگی کمتر.

<p align="center">
  <strong>یک برنامهٔ سبک، مدرن و فارسی برای مدیریت کارهای روزانه</strong>
</p>

<p align="center">
  <a href="https://github.com/dyfiydkyckg-create/TaskFlow"><img src="https://img.shields.io/badge/status-in%20development-6558e8?style=for-the-badge" alt="Project status"></a>
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.0+">
  <img src="https://img.shields.io/badge/Language-Persian%20%7C%20RTL-16A085?style=for-the-badge" alt="Persian RTL">
  <img src="https://img.shields.io/badge/License-MIT-2EA44F?style=for-the-badge" alt="MIT License">
</p>

---

## دربارهٔ پروژه

**TaskFlow** یک اپلیکیشن مدیریت وظایف با رابط کاربری فارسی و راست‌چین است. هدف آن ساده است: کارهایت را ثبت کن، اولویت بده، وضعیتشان را دنبال کن و با دید روشن‌تری جلو برو.

این پروژه با PHP و پایگاه دادهٔ MySQL ساخته شده و برای یادگیری توسعهٔ وب، تمرین کار با دیتابیس و ساخت یک پروژهٔ قابل توسعه مناسب است.

## ✨ امکانات

| قابلیت | توضیح |
| --- | --- |
| ساخت کار | ثبت عنوان، توضیحات، وضعیت، اولویت و تاریخ سررسید |
| ویرایش کار | به‌روزرسانی اطلاعات هر وظیفه |
| حذف امن | حذف از طریق فرم POST همراه با محافظت CSRF |
| داشبورد آماری | مشاهدهٔ تعداد کل، در انتظار، در حال انجام و تکمیل‌شده؛ همراه با کارت هشدار قابل کلیک برای وظایف عقب‌افتاده |
| جست‌وجو | جست‌وجو در عنوان و توضیحات |
| فیلتر وضعیت | نمایش کارها بر اساس وضعیت، از جمله کارهای عقب‌افتاده |
| تشخیص تأخیر | یک شرط مشترک برای فیلتر، شمارش، شدت هشدار و برجسته‌سازی کارهای تکمیل‌نشده با موعد گذشته |
| اولویت‌بندی | سه سطح کم، متوسط و زیاد |
| طراحی واکنش‌گرا | تجربهٔ مناسب در موبایل و دسکتاپ |
| پشتیبانی فارسی | رابط راست‌چین و ذخیره‌سازی UTF-8 |

## 🧰 فناوری‌ها

- **Backend:** PHP 8.1+
- **Database:** MySQL 8.0+ / MariaDB سازگار
- **Database access:** PDO و prepared statements
- **Frontend:** HTML5 و CSS3
- **Typography:** Vazirmatn

## 🚀 شروع سریع

### پیش‌نیازها

PHP 8.1 یا جدیدتر، MySQL، و افزونه‌های PHP یعنی pdo_mysql و mbstring را نصب کنید.

### نصب

    git clone https://github.com/dyfiydkyckg-create/TaskFlow.git
    cd TaskFlow

### راه‌اندازی دیتابیس

    mysql -u root -p < database/schema.sql

### تنظیم اتصال

متغیرهای محیطی اتصال دیتابیس را تنظیم کنید: DB_HOST، DB_PORT، DB_NAME، DB_USER، DB_PASS و DB_CHARSET.

### اجرای محلی

    php -S localhost:8000

حالا وارد http://localhost:8000 شوید.

> راهنمای کامل نصب، تنظیم محیط و عیب‌یابی در docs/INSTALLATION.md قرار دارد.

## 📁 ساختار پروژه

    TaskFlow/
    ├── assets/css/style.css
    ├── config/database.php
    ├── database/schema.sql
    ├── docs/
    │   ├── CONTRIBUTING.md
    │   └── INSTALLATION.md
    ├── includes/
    │   ├── footer.php
    │   ├── functions.php
    │   └── header.php
    ├── .env.example
    ├── .gitignore
    ├── create.php
    ├── delete.php
    ├── edit.php
    ├── index.php
    └── README.md

## 🛡️ نکات امنیتی

- اجرای کوئری‌ها با PDO و prepared statements
- Escape کردن خروجی‌ها برای کاهش ریسک XSS
- اعتبارسنجی ورودی‌های فرم در سمت سرور
- محافظت CSRF برای عملیات تغییردهندهٔ داده
- حذف فقط از طریق درخواست POST
- نگهداری اطلاعات اتصال در متغیرهای محیطی

## 🗺️ نقشهٔ راه

- [x] داشبورد و نمایش آمار
- [x] ساخت، ویرایش و حذف وظایف
- [x] جست‌وجو و فیلتر وضعیت
- [x] اولویت و تاریخ سررسید
- [x] فیلتر و شمارش وظایف عقب‌افتاده با شرط مشترک و کارت هشدار قابل کلیک
- [x] طراحی واکنش‌گرا و فارسی
- [ ] ورود و ثبت‌نام کاربران
- [ ] دسته‌بندی و برچسب‌گذاری
- [ ] مرتب‌سازی پیشرفته و صفحه‌بندی
- [ ] تست خودکار

## 🤝 مشارکت

ایده‌ها، گزارش باگ‌ها و Pull Requestها خوشحالمان می‌کنند. لطفاً پیش از مشارکت، راهنمای مشارکت در docs/CONTRIBUTING.md را بخوانید.

## 📄 مجوز

این پروژه با مجوز MIT منتشر می‌شود. جزئیات در فایل LICENSE آمده است.

---

<p align="center">
  ساخته‌شده برای برنامه‌ریزی بهتر؛ یک کار در هر لحظه. ✦
</p>
