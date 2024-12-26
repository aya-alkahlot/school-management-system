<?php

use Illuminate\Database\Seeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\BloodTableSeeder;
use Database\Seeders\GenderTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\ParentsTableSeeder;
use Database\Seeders\ReligionTableSeeder;
use Database\Seeders\SectionsTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\ClassroomTableSeeder;
use Database\Seeders\NationalitiesTableSeeder;
use Database\Seeders\SpecializationsTableSeeder;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();
		$this->call(BloodTableSeeder::class);
		$this->call(NationalitiesTableSeeder::class);
		$this->call(ReligionTableSeeder::class);
		$this->call(SpecializationsTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(ClassroomTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(ParentsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
	}
}