<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($productDetail) {
            do {
                $token = \Illuminate\Support\Str::random(30);
            } while (ProductDetail::where('token', $token)->exists());
            $productDetail->token = $token;
            // $productDetail->name = $productDetail->name
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
