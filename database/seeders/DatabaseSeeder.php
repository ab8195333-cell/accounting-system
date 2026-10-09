<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إضافة الحسابات الأساسية في قاعدة البيانات
        Account::updateOrCreate(['id' => 1], ['code' => '101', 'name' => 'الصندوق الرئيسي', 'type' => 'asset']);
        Account::updateOrCreate(['id' => 2], ['code' => '102', 'name' => 'بنك الأهلي', 'type' => 'asset']);
        Account::updateOrCreate(['id' => 3], ['code' => '201', 'name' => 'الموردون', 'type' => 'liability']);
        Account::updateOrCreate(['id' => 4], ['code' => '401', 'name' => 'إيراد مبيعات البرامج', 'type' => 'revenue']);
    }
}