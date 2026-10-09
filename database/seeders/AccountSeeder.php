<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::create(['id' => 1, 'code' => '101', 'name' => 'الصندوق الرئيسي', 'type' => 'asset']);
        Account::create(['id' => 2, 'code' => '102', 'name' => 'بنك الأهلي', 'type' => 'asset']);
        Account::create(['id' => 3, 'code' => '201', 'name' => 'الموردون', 'type' => 'liability']);
        Account::create(['id' => 4, 'code' => '401', 'name' => 'إيراد مبيعات البرامج', 'type' => 'revenue']);
    }
}
