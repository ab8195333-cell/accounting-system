<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalEntryController;

// مسار عرض الواجهة
Route::get('/accounting', function () {
    return view('accounting.index');
});

// مسار حفظ القيد المحاسبي
Route::post('/api/journal-entries', [JournalEntryController::class, 'store']);