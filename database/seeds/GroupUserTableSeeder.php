<?php

use Illuminate\Database\Seeder;
use App\Models\GroupUser;

class GroupUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupUser::create([
            'group_id' => '1',
            'user_id' => '1',
            'group_user_role_id' => '1',
            'accepted' => '1'
        ]);

        GroupUser::create([
            'group_id' => '1',
            'user_id' => '2',
            'group_user_role_id' => '2',
            'accepted' => '1'
        ]);

        GroupUser::create([
            'group_id' => '1',
            'user_id' => '3',
            'group_user_role_id' => '3',
            'accepted' => '1'
        ]);

//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '4',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '5',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '6',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '7',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '8',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '9',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '10',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);
//
//        GroupUser::create([
//            'group_id' => '1',
//            'user_id' => '11',
//            'group_user_role_id' => '3',
//            'accepted' => '1'
//        ]);


    }
}
