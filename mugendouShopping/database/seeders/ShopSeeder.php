<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'ownerId' => 1,
                'name' => 'テスト店名1',
                'information' => 'お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報',
                'imageName' => '',
                'isEnable' => true,
            ],
            [
                'ownerId' => 2,
                'name' => 'テスト店名2',
                'information' => 'お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報お店の情報',
                'imageName' => '',
                'isEnable' => true,
            ],
        ];
        foreach ($params as $param) {
            DB::table('shops')->insert($param);
        }
    }
}
