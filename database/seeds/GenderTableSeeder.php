<?php

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderTableSeeder extends Seeder {

	public function run()
	{

		Gender::create([
			'gender' => 'male',
		]);

		Gender::create([
			'gender' => 'female',
		]);

		Gender::create([
			'gender' => 'neutral',
		]);
	}

}
