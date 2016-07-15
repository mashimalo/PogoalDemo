<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder {

	public function run()
	{
		Profile::create([
			'user_id' => 1,
			'nickname' => 'zhengwg',
			'first_name' => 'Weiguo',
			'last_name' => 'Zheng',
			'gender_id' => 1,
			'date_of_birth' => '1983-09-09',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 2,
			'nickname' => 'admin',
			'first_name' => 'ad',
			'last_name' => 'min',
			'gender_id' => 1,
			'date_of_birth' => '1980-01-01',
			'bio' => 'Nothing to say here yet.',
		]);

		Profile::create([
			'user_id' => 3,
			'nickname' => 'test1',
			'first_name' => 'test1',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);

		Profile::create([
			'user_id' => 4,
			'nickname' => 'test2',
			'first_name' => 'test2',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 5,
			'nickname' => 'test3',
			'first_name' => 'test3',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 6,
			'nickname' => 'test4',
			'first_name' => 'test4',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 7,
			'nickname' => 'test5',
			'first_name' => 'test5',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 8,
			'nickname' => 'test6',
			'first_name' => 'test6',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 9,
			'nickname' => 'test7',
			'first_name' => 'test7',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 10,
			'nickname' => 'test8',
			'first_name' => 'test8',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 11,
			'nickname' => 'test9',
			'first_name' => 'test9',
			'last_name' => 'test',
			'gender_id' => 2,
			'date_of_birth' => '1970-01-01',
			'bio' => 'Nothing to say here yet.',
		]);


	}

}
