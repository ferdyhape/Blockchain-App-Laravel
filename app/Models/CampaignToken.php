<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignToken extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // when boot, generate token like generate uuid on boot

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sold_to', 'id');
    }
}
