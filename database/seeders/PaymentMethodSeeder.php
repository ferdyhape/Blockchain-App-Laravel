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
                'details' => [
                    [
                        'name' => 'Bank Mandiri',
                        'description' => '<h4>Payment via Bank Mandiri Teller</h4><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><ol><li>Come to Mandiri bank teller</li><li>Please provide the number in the <strong>VA NUMBER </strong>column to the teller clerk as the transfer destination along with the money in accordance with the bill amount</li><li>The teller will check the data and make a payment to the virtual account number. After the transaction is successful, then you will get proof of deposit from the teller.</li><li>Payment confirmation to ADMIN payway.uns.ac.id can be done at least 1 day after payment is made</li></ol><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><h4>Payments by Mandiri ATM</h4><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><ol><li>Insert an ATM card</li><li>Then select <strong>LANGUAGE INDONESIA</strong></li><li>Type ATM card PIN, then press Enter</li><li>Select the <strong>PAY / BUY </strong>menu</li><li>Select the <strong>EDUCATION </strong>menu</li><li>Type in the company code, which is <strong>"88576" </strong>(UNS VA), press <strong>TRUE</strong></li><li>Enter <strong>VA NUMBER </strong>which is listed on <i><strong>invoice </strong></i>from payway.uns.ac.id</li><li>Will confirm the customer data. <strong>Make sure </strong>there is <i>prefix </i><strong>"UNSVA -" </strong>before your name. Then press <strong>YES</strong></li><li>Confirm payment appears, press <strong>YES </strong>to make payment</li><li>After the transaction is successful, it will exit STRUK which can be saved as payment proof</li><li>Payment confirmation to admin payway.uns.ac.id can be done at least 1 day after payment is made</li></ol><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><h4>Payment via ATM Other Bank</h4><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><ol><li>In the main menu, select the <strong>Transfer </strong>menu</li><li>Select a transaction destination to <strong>Other Bank Account</strong></li><li>Enter <strong>Mandiri bank code </strong>and <strong>virtual account number (VA Number) </strong>as payment destination</li><li>Enter <strong>nominal to be transferred </strong>. Make sure you enter the same nominal amount as the bill</li><li>Confirmation of customer data and nominal transfer will appear. If it is correct, please press <strong>YES</strong></li><li>After the transaction is successful, it will exit STRUK which can be saved as payment proof</li><li>Payment confirmation to admin payway.uns.ac.id can be done at least 1 day after payment is made</li></ol>',
                    ],
                    [
                        'name' => 'Bank BCA',
                        'description' => '<h4>BCA mobile</h4><ol><li>Open BCA mobile, select “m-Transfer”</li><li>Select “BCA Virtual Account”</li><li>Enter the BCA Virtual Account number and click “Send”</li><li>Check the amount that shows</li><li>Enter m-BCA PIN</li><li>Transaction is successful</li></ol><p>&nbsp;</p>',
                    ],
                ],
            ],
            // [
            //     'name' => 'Wallet Saldo',
            //     'description' => 'Pay using your wallet saldo',
            //     'details' => [
            //         [
            //             'name' => 'Your Wallet Saldo',
            //             'description' => 'Pay using your wallet saldo',
            //         ],
            //     ],
            // ],
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
