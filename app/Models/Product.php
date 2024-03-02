<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
