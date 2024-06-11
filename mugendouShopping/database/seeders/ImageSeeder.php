<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'ownerId' => 1,
                'imageName' => '1.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '2.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '3.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '4.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '5.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '6.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '7.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '8.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => '9.jpg',
            ],
        ]);
    }
}
