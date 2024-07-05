<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear all data on wallet_transactions, wallet_transaction_users, wallets
        $deleteTableName = ['wallet_transactions', 'wallet_transaction_users', 'wallets'];
        foreach ($deleteTableName as $table) {
            DB::table($table)->truncate();
            $this->info('Table ' . $table . ' has been cleared');
        }

        // update data on campaigns, set sold_token_amount to 0
        if (Campaign::count() > 0) {
            Campaign::query()->update(['sold_token_amount' => 0]);
            $this->info('Table campaigns has been updated');
        } else {
            $this->info('Table campaigns is empty');
        }


        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
