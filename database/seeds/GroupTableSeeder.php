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
            'description' => 'Test Group ZWG',
            'group_type_id' => '6',
            'privacy_rule_id' => '1',

        ]);

        Group::create([
            'name' => 'Test Idea Validation Group',
            'description' => 'Test Idea Validation Group',
            'group_type_id' => '1',
            'privacy_rule_id' => '1',

        ]);

        Group::create([
            'name' => 'Test MVP Feedback Group',
            'description' => 'Test MVP Feedback Group',
            'group_type_id' => '2',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Product Review Group',
            'description' => 'Test Product Review group',
            'group_type_id' => '3',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Geek Corner Group',
            'description' => 'Test Geek Corner Group',
            'group_type_id' => '4',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Burnout Cave Group',
            'description' => 'Test Burnout Cave test group',
            'group_type_id' => '5',
            'privacy_rule_id' => '1',
        ]);

        Group::create([
            'name' => 'Test Random Topics Group',
            'description' => 'Test Other Topics Groups',
            'group_type_id' => '6',
            'privacy_rule_id' => '1',
        ]);
    }
}
