<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($transaction) {
            do {
                $transaction_code = \Illuminate\Support\Str::random(15);
            } while (Transaction::where('transaction_code', $transaction_code)->exists());
            $transaction->transaction_code = $transaction_code;
        });
    }


    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
