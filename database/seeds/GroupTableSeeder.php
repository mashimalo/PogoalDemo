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
            'privacy_rule_id' => '2',
        ]);
    }
}
