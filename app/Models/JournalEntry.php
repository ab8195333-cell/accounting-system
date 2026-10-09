<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = ['entry_number', 'date', 'description'];

    public function items()
    {
        return $this->hasMany(JournalEntryItem::class);
    }
}