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
                'imageName' => 'sample1.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => 'sample2.jpg',
            ],
            [
                'ownerId' => 1,
                'imageName' => 'sample3.jpg',
            ],
        ]);
    }
}
