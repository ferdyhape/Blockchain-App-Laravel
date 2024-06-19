<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class PaymentMethodDetail extends Model implements HasMedia
{
    use HasFactory,
        HasUuids,
        InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
