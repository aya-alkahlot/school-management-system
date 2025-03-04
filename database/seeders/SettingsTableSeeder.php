<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->delete();

        $data = [
            ['key' => 'current_session', 'value' => '2024-2025'],
            ['key' => 'school_title', 'value' => 'IS'],
            ['key' => 'school_name', 'value' => 'Islamic International Schools'],
            ['key' => 'end_first_term', 'value' => '01-12-2024'],
            ['key' => 'end_second_term', 'value' => '01-03-2025'],
            ['key' => 'phone', 'value' => '0123456789'],
            ['key' => 'address', 'value' => 'غزة'],
            ['key' => 'school_email', 'value' => 'info@Islamic.com'],
            ['key' => 'logo', 'value' => '1.jpg'],
        ];

        DB::table('settings')->insert($data);
    }
}
