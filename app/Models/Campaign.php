<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MannikJ\Laravel\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory,
        HasUuids,
        HasWallet;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($campaign) {
            $campaign->campaign_code = 'C' . date('Ymd') . '-' . (self::count() + 1);
        });
    }

    protected static function booted()
    {
        static::creating(function ($campaign) {
            // Ambil kategori status pengajuan berdasarkan nama
            $categoryStatus = CategoryProjectSubmissionStatus::where('name', 'Proses Tanda Tangan Kontrak')->first();
            $relatedProject = Project::find($campaign->project_id);
            // Jika tidak ada kategori status atau kategorinya tidak sama dengan 'Proses Penggalangan Dana', maka batalkan pembuatan entitas
            if (!$categoryStatus || $relatedProject->category_project_submission_status_id !== $categoryStatus->id) {
                return false;
            }
        });
    }

    // Accessor for user_token_count
    public function getUserTokenCountAttribute()
    {
        return CampaignToken::where('sold_to', auth()->id())
            ->where('campaign_id', $this->id)
            ->where('status', 'sold')
            ->count();
    }

    // relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function campaignTokens()
    {
        return $this->hasMany(CampaignToken::class);
    }

    public function walletTransactions()
    {
        return $this->morphMany(WalletTransactionUser::class, 'walletable');
    }
}
