<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Bank Transfer',
                'description' => 'Transfer money from your bank account to our bank account',
                // 'details' => [
                //     [
                //         'name' => 'Bank Mandiri',
                //         'description' => 'Bank Mandiri 1234567890 a/n PT. Example',
                //     ],
                //     [
                //         'name' => 'Bank BCA',
                //         'description' => 'Bank BCA 1234567890 a/n PT. Example',
                //     ],
                // ],
            ],
            [
                'name' => 'Wallet Saldo',
                'description' => 'Pay using your wallet saldo',
            ],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodModel = \App\Models\PaymentMethod::create([
                'name' => $paymentMethod['name'],
                'description' => $paymentMethod['description'],
            ]);

            if (isset($paymentMethod['details'])) {
                foreach ($paymentMethod['details'] as $detail) {
                    \App\Models\PaymentMethodDetail::create([
                        'name' => $detail['name'],
                        'description' => $detail['description'],
                        'payment_method_id' => $paymentMethodModel->id,
                    ]);
                }
            }
        }
    }
}
