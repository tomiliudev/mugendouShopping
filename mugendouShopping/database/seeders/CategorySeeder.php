<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('primary_categories')->insert([
            [
                'name' => '飛行機',
                'sortOrder' => 1
            ],
            [
                'name' => '車',
                'sortOrder' => 2
            ],
            [
                'name' => '動物',
                'sortOrder' => 3
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '旅客機',
                'sortOrder' => 1,
                'primaryId' => 1
            ],
            [
                'name' => '戦闘機',
                'sortOrder' => 2,
                'primaryId' => 1
            ],
            [
                'name' => '貨物機',
                'sortOrder' => 3,
                'primaryId' => 1
            ],

            [
                'name' => 'スーパーカー',
                'sortOrder' => 4,
                'primaryId' => 2
            ],
            [
                'name' => 'トラック',
                'sortOrder' => 5,
                'primaryId' => 2
            ],
            [
                'name' => 'キャンピングカー',
                'sortOrder' => 6,
                'primaryId' => 2
            ],

            [
                'name' => 'ひつじ',
                'sortOrder' => 7,
                'primaryId' => 3
            ],
            [
                'name' => 'ねこ',
                'sortOrder' => 8,
                'primaryId' => 3
            ],
            [
                'name' => '豚',
                'sortOrder' => 9,
                'primaryId' => 3
            ],
        ]);
    }
}
