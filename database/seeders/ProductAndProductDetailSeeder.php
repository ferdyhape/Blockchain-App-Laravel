<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAndProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomThreeCompanyName = \App\Models\Company::inRandomOrder()->limit(3)->pluck('name')->toArray();

        foreach ($randomThreeCompanyName as $company_name) {
            $divided_into = 5; // dibagi menjadi 5 bagian 
            $nominated_requested = 100000000; // Rp 100.000.000
            $product = \App\Models\Product::create([
                'company_id' => \App\Models\Company::inRandomOrder()->first()->id,
                'name' => 'Saham ' . $company_name,
                'description' => 'Description of Saham ' . $company_name,
                'divided_into' => $divided_into,
                'nominal_requested' => (string) $nominated_requested,
            ]);

            for ($i = 1; $i <= $divided_into; $i++) {
                \App\Models\ProductDetail::create([
                    'product_id' => $product->id,
                    'price' => (string) ($nominated_requested / $divided_into), // Rp 100.000.000 / 5 = Rp 20.000.000
                ]);
            }
        }
    }
}
