<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => 'test_admin_1',
                'email' => 'test_admin_1@email.com',
                'password' => Hash::make('password'),
                'created_at' => '2023-03-01 12:11:15',
            ],
        ];

        foreach ($params as $param) {
            DB::table('admins')->insert($param);
        }
    }
}
