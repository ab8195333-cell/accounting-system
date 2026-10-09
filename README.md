# 📊 Accounting System | النظام المحاسبي المتكامل

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

نظام محاسبي ومالي متكامل لإدارة المعاملات المالية، القيود اليومية، الحسابات الشجرية، والفواتير بدقة وفق مبادئ القيد المزدوج (Double-entry bookkeeping).

## 🚀 المميزات الرئيسية
- **دليل الحسابات (Chart of Accounts):** هيكلية شجرية مرنة للحسابات (أصول، خصوم، إيرادات، مصاريف، حقوق ملكية).
- **القيود اليومية والسندات:** إنشاء القيود اليومية مع التحقق التلقائي من توازن (مدين / دائن)، وسندات القبض والصرف.
- **إدارة الفواتير والعملاء/الموردين:** فواتير المبيعات والمشتريات ومردوداتها مع كشوفات حساب تفصيلية.
- **التقارير المالية:** كشف حساب، ميزان المراجعة، قائمة الدخل (الأرباح والخسائر)، والميزانية العمومية.

## 🛠️ التقنيات المستخدمة
- **Backend:** PHP / Laravel
- **Database:** MySQL
- **Frontend:** Blade Templates, Bootstrap, JavaScript

## ⚙️ خطوات التثبيت والتشغيل
```bash
# 1. استنسخ المستودع
git clone [https://github.com/ab8195333-cell/accounting-system.git](https://github.com/ab8195333-cell/accounting-system.git)
cd accounting-system

# 2. تثبيت الاعتماديات
composer install

# 3. إعداد ملف البيئة .env وإضافة بيانات قاعدة البيانات
cp .env.example .env
php artisan key:generate

# 4. تنفيذ التهجيرات والبيانات الأولية
php artisan migrate --seed

# 5. تشغيل السيرفر
php artisan serve
