<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder {

	public function run()
	{

		User::create([
			'email' => 'zhengweiguo@gmail.com',
			'password' => bcrypt('zheng1234!'),
			'role_id' => 1,
			'confirmed' => 1,
			'last_visit' => \Carbon\Carbon::now(),
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);

		User::create([
			'email' => 'admin@example.com',
			'password' => bcrypt('linhui1234!'),
			'role_id' => 1,
			'confirmed' => 1,
			'last_visit' => \Carbon\Carbon::now(),
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);

		User::create([
			'email' => 'test1@test.com',
			'password' => bcrypt('test1234!'),
			'role_id' => 2,
			'confirmed' => 1,
			'last_visit' => \Carbon\Carbon::now(),
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);

//		User::create([
//			'email' => 'test2@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test3@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test4@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test5@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test6@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test7@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test8@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);
//
//		User::create([
//			'email' => 'test9@test.com',
//			'password' => bcrypt('test1234!'),
//			'role_id' => 2,
//			'confirmed' => 1,
//			'last_visit' => \Carbon\Carbon::now(),
//			'confirmation_code' => md5(microtime() . env('APP_KEY')),
//		]);

	}

}
