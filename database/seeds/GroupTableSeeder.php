<?php

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => 'Test Group - zwg',
            'description' => 'test group 1 description',
            'group_type_id' => '1',
            'privacy_rule_id' => '1',

        ]);

        Group::create([
            'name' => 'Test Group 2',
            'description' => 'test group 2 description',
            'group_type_id' => '2',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Group 3',
            'description' => 'test group3',
            'group_type_id' => '3',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Group 4',
            'description' => 'test group4',
            'group_type_id' => '4',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'test name5',
            'description' => 'test group5',
            'group_type_id' => '5',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'test name6',
            'description' => 'test group6',
            'group_type_id' => '6',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name7',
            'description' => 'mock group7',
            'group_type_id' => '7',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name8',
            'description' => 'mock group8',
            'group_type_id' => '8',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name9',
            'description' => 'mock group9',
            'group_type_id' => '9',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name10',
            'description' => 'mock group10',
            'group_type_id' => '10',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name11',
            'description' => 'mock group11',
            'group_type_id' => '11',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'mock name12',
            'description' => 'test group12',
            'group_type_id' => '12',
            'privacy_rule_id' => '1',
        ]);


    }
}
