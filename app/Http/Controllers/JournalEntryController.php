<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\JournalEntryItem;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class JournalEntryController extends Controller
{
    public function store(Request $request)
    {
        // 1. إضافة الحسابات تلقائياً في قاعدة البيانات إذا كانت فارغة
        if (Account::count() === 0) {
            Account::insert([
                ['id' => 1, 'code' => '101', 'name' => 'الصندوق الرئيسي', 'type' => 'asset', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'code' => '102', 'name' => 'بنك الأهلي', 'type' => 'asset', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'code' => '201', 'name' => 'الموردون', 'type' => 'liability', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'code' => '401', 'name' => 'إيراد مبيعات البرامج', 'type' => 'revenue', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // 2. التحقق من البيانات المدخلة
      // 1. التحقق من أن رقم القيد فريد
$request->validate([
    'entry_number' => 'required|unique:journal_entries,entry_number',
    'date'         => 'required|date',
    'description'  => 'nullable|string',
    'items'        => 'required|array|min:2',
    'items.*.account_id' => 'required',
    'items.*.debit'      => 'numeric|min:0',
    'items.*.credit'     => 'numeric|min:0',
], [
    'entry_number.unique' => 'رقم القيد هذا مستخدم من قبل، يرجى كتابة رقم قيد جديد.'
]);

        // 3. التأكد من توازن القيد (المدين = الدائن)
        $totalDebit  = array_sum(array_column($request->items, 'debit'));
        $totalCredit = array_sum(array_column($request->items, 'credit'));

        if (abs($totalDebit - $totalCredit) > 0.001) {
            return response()->json([
                'message' => 'القيد غير متوازن! يجب أن يتساوى إجمالي المدين مع إجمالي الدائن.'
            ], 422);
        }

        // 4. حفظ القيد وتفاصيله داخل Transaction
        try {
            DB::beginTransaction();

            $entry = JournalEntry::create([
                'entry_number' => $request->entry_number,
                'date'         => $request->date,
                'description'  => $request->description,
            ]);

           foreach ($request->items as $item) {
    // البحث عن الحساب بواسطة ID أو الكود code
    $account = Account::where('id', $item['account_id'])
                      ->orWhere('code', $item['account_id'])
                      ->first();

    if ($account) {
        JournalEntryItem::create([
            'journal_entry_id' => $entry->id,
            'account_id'       => $account->id, // استخدام الـ Primary Key الصحيح
            'debit'            => $item['debit'],
            'credit'           => $item['credit'],
        ]);
    }
}

            DB::commit();

            return response()->json([
                'message' => 'تم حفظ وترحيل القيد المحاسبي بنجاح!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
            ], 500);
        }
    }
}