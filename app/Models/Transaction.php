<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $prefix = $transaction->order_type === 'sell' ? 'TS' : 'TB';
            $transaction->transaction_code = $prefix . date('Ymd') . '-' . (self::count() + 1);
        });
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_code', 'transaction_code');
    }
}
