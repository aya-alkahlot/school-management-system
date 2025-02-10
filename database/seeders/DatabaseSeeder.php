<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\BloodTableSeeder;
use Database\Seeders\GenderTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\ParentsTableSeeder;
use Database\Seeders\ReligionTableSeeder;
use Database\Seeders\SectionsTableSeeder;
use Database\Seeders\SettingsTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\ClassroomTableSeeder;
use Database\Seeders\NationalitiesTableSeeder;
use Database\Seeders\SpecializationsTableSeeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            UserSeeder::class,
            BloodTableSeeder::class,
            NationalitiesTableSeeder::class,
            ReligionTableSeeder::class,
            SpecializationsTableSeeder::class,
            GenderTableSeeder::class,
            GradeSeeder::class,
            ClassroomTableSeeder::class,
            SectionsTableSeeder::class,
            ParentsTableSeeder::class,
            StudentsTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }

}