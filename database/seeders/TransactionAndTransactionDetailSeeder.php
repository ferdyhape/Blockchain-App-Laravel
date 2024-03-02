<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionAndTransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $selectedProduct = \App\Models\Product::with('productDetails')->inRandomOrder()->first();
        $randomBuyerFromUserWIthRoleShareholder = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'Shareholder');
        })->inRandomOrder()->first();
        $selectedProductDetail = $selectedProduct->productDetails->where('buyer_id', null)->random();
        $sumOfBuyingProduct = 1;

        $transaction = \App\Models\Transaction::create([
            'buyer' => $randomBuyerFromUserWIthRoleShareholder->name,
            'seller_company' => $selectedProduct->company->name,
            'sum_of_product' => $sumOfBuyingProduct,
            'total_price' => (string) ($sumOfBuyingProduct * $selectedProductDetail->price),
        ]);

        foreach (range(1, $sumOfBuyingProduct) as $index) {
            \App\Models\TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_name' => $selectedProduct->name,
                'product_description' => $selectedProduct->description,
                'token_of_product' => $selectedProductDetail->token,
                'price' => $selectedProductDetail->price,
            ]);

            \App\Models\ProductDetail::where('id', $selectedProductDetail->id)->update(['buyer_id' => $randomBuyerFromUserWIthRoleShareholder->id]);
        }
    }
}
