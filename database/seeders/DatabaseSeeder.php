<?php

use Illuminate\Database\Seeder;
use Database\Seeders\BloodTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\ReligionTableSeeder;
use Database\Seeders\NationalitiesTableSeeder;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();
		$this->call(BloodTableSeeder::class);
		$this->call(NationalitiesTableSeeder::class);
		$this->call(ReligionTableSeeder::class);
	}
}