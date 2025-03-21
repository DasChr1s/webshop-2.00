<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {

        //testdaten für die produkte
        DB::table('products')->insert([
            [
                'name' => 'Shylily',
                'description' => 'This is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one.',
                'price' => 15,
                'tax_rate' => 20,
                'image_url' => 'shylily.jpg',
                'sku' => 'LILY1234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stare Catto',
                'description' => 'This is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one.',
                'price' => 20,
                'tax_rate' => 20,
                'image_url' => 'cat.jpg',
                'sku' => 'CATTO5678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Harold',
                'description' => 'This is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one. It is the best widget you will ever buy. It is so cool that you will want to buy another one.',
                'price' => 50,
                'tax_rate' => 20,
                'image_url' => 'harold.jpg',
                'sku' => 'HAROLD1234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
