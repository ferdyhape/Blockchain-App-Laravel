<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\TransactionService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddTokenProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $relatedCampaign;
    protected $transactionCode;
    protected $quantity;
    protected $userId;
    protected $orderType;

    public function __construct($relatedCampaign, $transactionCode, $quantity, $userId, $orderType)
    {
        $this->relatedCampaign = $relatedCampaign;
        $this->transactionCode = $transactionCode;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->orderType = $orderType;
    }

    public function handle()
    {
        $timenow = now()->toDateTimeString();
        Log::channel('queue_logs')->info('Job started at ' . $timenow);
        Log::channel('queue_logs')->info('Job data: ' . $this->relatedCampaign . ', ' . $this->transactionCode . ', ' . $this->quantity . ', ' . $this->userId . ', ' . $this->orderType);


        // Lakukan pekerjaan antrian Anda di sini
        try {
            TransactionService::addToken($this->relatedCampaign, $this->transactionCode, $this->quantity, $this->orderType, $this->userId);
        } catch (\Exception $e) {
            Log::channel('queue_logs')->error('Error executing addTransactionDetail: ' . $e->getMessage());
        }
    }
}
