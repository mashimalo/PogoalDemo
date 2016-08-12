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
			'date_of_birth' => '1986-09-09',
			'bio' => 'Nothing to say here yet.',
		]);
		Profile::create([
			'user_id' => 2,
			'nickname' => 'admin',
			'first_name' => 'hui',
			'last_name' => 'lin',
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

//		Profile::create([
//			'user_id' => 4,
//			'nickname' => 'auth',
//			'first_name' => 'test2',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 5,
//			'nickname' => 'docking',
//			'first_name' => 'test3',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 6,
//			'nickname' => 'group',
//			'first_name' => 'test4',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 7,
//			'nickname' => 'home',
//			'first_name' => 'test5',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 8,
//			'nickname' => 'leaderboard',
//			'first_name' => 'test6',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 9,
//			'nickname' => 'notifications',
//			'first_name' => 'test7',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 10,
//			'nickname' => 'password',
//			'first_name' => 'test8',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);
//		Profile::create([
//			'user_id' => 11,
//			'nickname' => 'profile',
//			'first_name' => 'test9',
//			'last_name' => 'test',
//			'gender_id' => 2,
//			'date_of_birth' => '1970-01-01',
//			'bio' => 'Nothing to say here yet.',
//		]);

	}

}
