<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'shopId' => 1,
                'name' => '商品１',
                'information' => '商品１の情報です。商品１の情報です。商品１の情報です。商品１の情報です。商品１の情報です。商品１の情報です。',
                'price' => 35050,
                'isSelling' => true,
                'sortOrder' => 1,
                'stock' => 5,
                'secondaryId' => 1,
                'image1' => 1,
                'image2' => null,
                'image3' => null,
                'image4' => null,
            ],
            [
                'shopId' => 1,
                'name' => '商品２',
                'information' => '商品２の情報です。商品２の情報です。商品２の情報です。商品２の情報です。商品２の情報です。商品２の情報です。',
                'price' => 85050,
                'isSelling' => true,
                'sortOrder' => 2,
                'stock' => 15,
                'secondaryId' => 2,
                'image1' => 2,
                'image2' => null,
                'image3' => null,
                'image4' => null,
            ],
            [
                'shopId' => 1,
                'name' => '商品３',
                'information' => '商品３の情報です。商品３の情報です。商品３の情報です。商品３の情報です。商品３の情報です。商品３の情報です。',
                'price' => 21900,
                'isSelling' => false,
                'sortOrder' => 3,
                'stock' => 100,
                'secondaryId' => 3,
                'image1' => 3,
                'image2' => null,
                'image3' => null,
                'image4' => null,
            ],
        ]);
    }
}
