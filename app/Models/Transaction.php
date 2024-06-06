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
            $transaction->transaction_code = 'T' . date('Ymd') . '-' . (self::count() + 1);
        });
    }


    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
